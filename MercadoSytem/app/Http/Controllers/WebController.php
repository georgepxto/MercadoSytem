<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Box;
use App\Models\Entry;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasDashboardAccess()) {
                auth()->logout();
                return redirect('/login')->withErrors(['access' => 'Acesso negado ao dashboard.']);
            }
            return $next($request);
        });
    }
    public function index()
    {
        // Buscar dados no banco principal para check-in público
        $todayEntries = \DB::connection('main')->table('entries')
            ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
            ->join('boxes', 'entries.box_id', '=', 'boxes.id')
            ->whereDate('entries.entry_date', Carbon::today())
            ->orderBy('entries.entry_time', 'desc')
            ->select(
                'entries.*',
                'vendors.name as vendor_name',
                'vendors.food_type as vendor_food_type',
                'boxes.number as box_number',
                'boxes.location as box_location'
            )
            ->get()
            ->map(function($entry) {
                // Converter para objeto com propriedades acessíveis
                $entry->vendor = (object) [
                    'name' => $entry->vendor_name,
                    'food_type' => $entry->vendor_food_type
                ];
                $entry->box = (object) [
                    'number' => $entry->box_number,
                    'location' => $entry->box_location
                ];
                $entry->entry_time = Carbon::parse($entry->entry_time);
                $entry->exit_time = $entry->exit_time ? Carbon::parse($entry->exit_time) : null;
                return $entry;
            });
            
        $totalVendors = \DB::connection('main')->table('vendors')->where('active', true)->count();
        $totalBoxes = \DB::connection('main')->table('boxes')->where('available', true)->count();
        $activeEntries = \DB::connection('main')->table('entries')
            ->whereDate('entry_date', Carbon::today())
            ->whereNull('exit_time')
            ->count();

        $todayTotal = \DB::connection('main')->table('entries')
            ->whereDate('entry_date', Carbon::today())
            ->count();

        $lastWeekTotal = \DB::connection('main')->table('entries')
            ->whereDate('entry_date', Carbon::today()->subWeek())
            ->count();

        $weeklyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklyStats[] = [
                'date'  => $date->format('Y-m-d'),
                'label' => $date->locale('pt_BR')->isoFormat('ddd'),
                'count' => \DB::connection('main')->table('entries')->whereDate('entry_date', $date)->count(),
            ];
        }

        $allBoxes = \DB::connection('main')->table('boxes')->orderBy('number')->get()->map(function ($box) {
            $active = \DB::connection('main')->table('entries')
                ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
                ->where('entries.box_id', $box->id)
                ->whereNull('entries.exit_time')
                ->whereDate('entries.entry_date', \Carbon\Carbon::today())
                ->select('vendors.name as vendor_name', 'entries.entry_time')
                ->first();
            $box->is_occupied  = (bool) $active;
            $box->active_vendor = $active ? $active->vendor_name : null;
            $box->entry_time   = $active ? $active->entry_time : null;
            return $box;
        });

        return view('dashboard', compact(
            'todayEntries', 'totalVendors', 'totalBoxes', 'activeEntries',
            'todayTotal', 'lastWeekTotal', 'weeklyStats', 'allBoxes'
        ));
    }

    public function vendors()
    {
        // Use the Vendor model but specify the connection
        $vendors = \App\Models\Vendor::on('main')->with(['schedules.box'])->get();
        return view('vendors', compact('vendors'));
    }

    public function boxes()
    {
        // Buscar boxes do banco principal
        $boxesData = DB::connection('main')->table('boxes')
            ->orderBy('number')
            ->get();

        // Converter para formato compatível com a view e verificar status
        $boxes = $boxesData->map(function($box) {
            // Verificar se há entradas ativas (check-in sem check-out) para este box
            $activeEntry = DB::connection('main')->table('entries')
                ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
                ->where('entries.box_id', $box->id)
                ->whereNull('entries.exit_time')
                ->whereDate('entries.entry_date', Carbon::today())
                ->select('entries.*', 'vendors.name as vendor_name', 'vendors.email as vendor_email')
                ->first();

            // Determinar status real do box
            if (!$box->available) {
                // Se marcado como indisponível manualmente
                $box->status = 'indisponivel';
                $box->status_text = 'Indisponível';
                $box->status_class = 'bg-secondary';
            } elseif ($activeEntry) {
                // Se há alguém usando (entrada ativa)
                $box->status = 'ocupado';
                $box->status_text = 'Ocupado';
                $box->status_class = 'bg-warning';
                $box->active_entry = $activeEntry; // Para mostrar quem está usando
            } else {
                // Disponível para uso
                $box->status = 'disponivel';
                $box->status_text = 'Disponível';
                $box->status_class = 'bg-success';
            }

            $box->schedules = collect([]); // Para compatibilidade com a view
            return $box;
        });

        return view('boxes', compact('boxes'));
    }

    public function entries()
    {
        // Buscar dados no banco principal para mostrar check-ins
        $entriesQuery = DB::connection('main')->table('entries')
            ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
            ->join('boxes', 'entries.box_id', '=', 'boxes.id')
            ->orderBy('entries.entry_date', 'desc')
            ->orderBy('entries.entry_time', 'desc')
            ->select(
                'entries.*',
                'vendors.name as vendor_name',
                'vendors.food_type as vendor_food_type',
                'boxes.number as box_number',
                'boxes.location as box_location',
                'boxes.name as box_name'
            );

        // Paginar os resultados
        $entries = $entriesQuery->paginate(20);

        // Converter dados para formato compatível com a view
        foreach ($entries as $entry) {
            $entry->vendor = (object) [
                'name' => $entry->vendor_name,
                'food_type' => $entry->vendor_food_type
            ];
            $entry->box = (object) [
                'number' => $entry->box_number,
                'location' => $entry->box_location,
                'name' => $entry->box_name
            ];
            $entry->entry_time = Carbon::parse($entry->entry_time);
            $entry->exit_time = $entry->exit_time ? Carbon::parse($entry->exit_time) : null;
            $entry->entry_date = Carbon::parse($entry->entry_date);
        }
        
        return view('entries', compact('entries'));
    }

    public function checkin()
    {
        $vendors = Vendor::where('active', true)->get();
        $boxes = Box::where('available', true)->get();
        return view('checkin', compact('vendors', 'boxes'));
    }

    public function analytics()
    {
        $days = 30;
        $since = Carbon::today()->subDays($days - 1)->startOfDay();

        $topVendors = DB::connection('main')->table('entries')
            ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
            ->where('entries.entry_date', '>=', $since)
            ->select('vendors.name', DB::raw('COUNT(*) as count'))
            ->groupBy('vendors.id', 'vendors.name')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        $boxStats = DB::connection('main')->table('entries')
            ->join('boxes', 'entries.box_id', '=', 'boxes.id')
            ->where('entries.entry_date', '>=', $since)
            ->select('boxes.name', 'boxes.number', DB::raw('COUNT(*) as count'))
            ->groupBy('boxes.id', 'boxes.name', 'boxes.number')
            ->orderByDesc('count')
            ->get();

        $hourRaw = DB::connection('main')->table('entries')
            ->where('entry_date', '>=', $since)
            ->select(DB::raw('HOUR(entry_time) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('HOUR(entry_time)'))
            ->orderBy('hour')
            ->get()->keyBy('hour');

        $hourData = [];
        for ($h = 5; $h <= 22; $h++) {
            $hourData[] = ['label' => sprintf('%02dh', $h), 'count' => $hourRaw->get($h)?->count ?? 0];
        }

        $dayRaw = DB::connection('main')->table('entries')
            ->where('entry_date', '>=', $since)
            ->select(DB::raw('DAYOFWEEK(entry_date) as dow'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAYOFWEEK(entry_date)'))
            ->get()->keyBy('dow');

        // MySQL: 1=Dom,2=Seg,...7=Sáb
        $dayData = [];
        foreach ([2=>'Seg',3=>'Ter',4=>'Qua',5=>'Qui',6=>'Sex',7=>'Sáb',1=>'Dom'] as $d => $lbl) {
            $dayData[] = ['label' => $lbl, 'count' => $dayRaw->get($d)?->count ?? 0];
        }

        $avgStay = DB::connection('main')->table('entries')
            ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
            ->where('entries.entry_date', '>=', $since)
            ->whereNotNull('entries.exit_time')
            ->select('vendors.name', DB::raw('ROUND(AVG(TIMESTAMPDIFF(MINUTE, entry_time, exit_time)),0) as avg_min'))
            ->groupBy('vendors.id', 'vendors.name')
            ->orderByDesc('avg_min')
            ->limit(6)
            ->get();

        $totalPeriod = DB::connection('main')->table('entries')->where('entry_date', '>=', $since)->count();
        $prevSince   = Carbon::today()->subDays($days * 2 - 1)->startOfDay();
        $prevPeriod  = DB::connection('main')->table('entries')
            ->where('entry_date', '>=', $prevSince)
            ->where('entry_date', '<', $since)
            ->count();

        return view('analytics', compact(
            'topVendors', 'boxStats', 'hourData', 'dayData', 'avgStay',
            'totalPeriod', 'prevPeriod', 'days'
        ));
    }

    public function exportEntries(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date_format:Y-m-d',
            'date_to'   => 'nullable|date_format:Y-m-d',
            'vendor_id' => 'nullable|integer',
            'box_id'    => 'nullable|integer',
        ]);

        $query = DB::connection('main')->table('entries')
            ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
            ->join('boxes', 'entries.box_id', '=', 'boxes.id')
            ->select(
                'vendors.name as vendor_name', 'vendors.food_type',
                'boxes.number as box_number', 'boxes.location as box_location',
                'entries.entry_date', 'entries.entry_time', 'entries.exit_time'
            )
            ->orderBy('entries.entry_date', 'desc')
            ->orderBy('entries.entry_time', 'desc');

        if ($request->vendor_id) $query->where('entries.vendor_id', (int) $request->vendor_id);
        if ($request->box_id) $query->where('entries.box_id', (int) $request->box_id);
        if ($request->date_from) $query->whereDate('entries.entry_date', '>=', $request->date_from);
        if ($request->date_to) $query->whereDate('entries.entry_date', '<=', $request->date_to);

        $rows = $query->get();
        $filename = 'entradas_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Vendedor', 'Tipo', 'Box', 'Localização', 'Data', 'Entrada', 'Saída', 'Duração'], ';');
            foreach ($rows as $row) {
                $entry  = Carbon::parse($row->entry_time);
                $exit   = $row->exit_time ? Carbon::parse($row->exit_time) : null;
                $mins   = $exit ? $entry->diffInMinutes($exit) : null;
                $dur    = $mins !== null ? floor($mins / 60) . 'h ' . ($mins % 60) . 'min' : '-';
                fputcsv($out, [
                    $row->vendor_name,
                    $row->food_type,
                    $row->box_number,
                    $row->box_location,
                    Carbon::parse($row->entry_date)->format('d/m/Y'),
                    $entry->format('H:i'),
                    $exit ? $exit->format('H:i') : '-',
                    $dur,
                ], ';');
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
