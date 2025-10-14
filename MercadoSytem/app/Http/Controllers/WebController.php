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
            
        return view('dashboard', compact('todayEntries', 'totalVendors', 'totalBoxes', 'activeEntries'));
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
}
