<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Iniciar consulta no banco principal
        $query = DB::connection('main')->table('entries')
            ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
            ->join('boxes', 'entries.box_id', '=', 'boxes.id');

        // Aplicar filtros se fornecidos
        if ($request->has('vendor_id') && $request->vendor_id) {
            $query->where('entries.vendor_id', $request->vendor_id);
        }

        if ($request->has('box_id') && $request->box_id) {
            $query->where('entries.box_id', $request->box_id);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('entries.entry_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('entries.entry_date', '<=', $request->date_to);
        }

        $entries = $query->orderBy('entries.entry_date', 'desc')
            ->orderBy('entries.entry_time', 'desc')
            ->select(
                'entries.*',
                'vendors.name as vendor_name',
                'vendors.food_type as vendor_food_type',
                'boxes.number as box_number',
                'boxes.location as box_location',
                'boxes.name as box_name'
            )
            ->get()
            ->map(function($entry) {
                // Converter para formato esperado pela API
                return (object) [
                    'id' => $entry->id,
                    'vendor_id' => $entry->vendor_id,
                    'box_id' => $entry->box_id,
                    'entry_time' => $entry->entry_time,
                    'exit_time' => $entry->exit_time,
                    'entry_date' => $entry->entry_date,
                    'notes' => $entry->notes,
                    'vendor' => (object) [
                        'name' => $entry->vendor_name,
                        'food_type' => $entry->vendor_food_type
                    ],
                    'box' => (object) [
                        'number' => $entry->box_number,
                        'location' => $entry->box_location,
                        'name' => $entry->box_name
                    ]
                ];
            });
        
        return response()->json($entries);
    }

    /**
     * Store a newly created resource in storage (Check-in).
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'box_id' => 'required|exists:boxes,id',
            'notes' => 'nullable|string'
        ]);

        $entry = Entry::create([
            'vendor_id' => $request->vendor_id,
            'box_id' => $request->box_id,
            'entry_time' => Carbon::now(),
            'entry_date' => Carbon::now()->format('Y-m-d'),
            'notes' => $request->notes
        ]);

        return response()->json($entry->load(['vendor', 'box']), Response::HTTP_CREATED);
    }

    /**
     * Check-out (registrar saída).
     */
    public function checkOut($id)
    {
        // Buscar entrada no banco principal
        $entry = DB::connection('main')->table('entries')->where('id', $id)->first();
        
        if (!$entry) {
            return response()->json(['message' => 'Entrada não encontrada'], Response::HTTP_NOT_FOUND);
        }
        
        if ($entry->exit_time) {
            return response()->json(['message' => 'Saída já registrada'], Response::HTTP_BAD_REQUEST);
        }

        // Atualizar saída no banco principal
        DB::connection('main')->table('entries')
            ->where('id', $id)
            ->update(['exit_time' => Carbon::now()]);
        
        // Buscar dados atualizados com relações
        $updatedEntry = DB::connection('main')->table('entries')
            ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
            ->join('boxes', 'entries.box_id', '=', 'boxes.id')
            ->where('entries.id', $id)
            ->select(
                'entries.*',
                'vendors.name as vendor_name',
                'vendors.food_type as vendor_food_type',
                'boxes.number as box_number',
                'boxes.location as box_location',
                'boxes.name as box_name'
            )
            ->first();
        
        return response()->json([
            'id' => $updatedEntry->id,
            'vendor_id' => $updatedEntry->vendor_id,
            'box_id' => $updatedEntry->box_id,
            'entry_time' => $updatedEntry->entry_time,
            'exit_time' => $updatedEntry->exit_time,
            'entry_date' => $updatedEntry->entry_date,
            'notes' => $updatedEntry->notes,
            'vendor' => [
                'name' => $updatedEntry->vendor_name,
                'food_type' => $updatedEntry->vendor_food_type
            ],
            'box' => [
                'number' => $updatedEntry->box_number,
                'location' => $updatedEntry->box_location,
                'name' => $updatedEntry->box_name
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $entry = Entry::with(['vendor', 'box'])->findOrFail($id);
        return response()->json($entry);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $entry = Entry::findOrFail($id);
        
        $request->validate([
            'vendor_id' => 'exists:vendors,id',
            'box_id' => 'exists:boxes,id',
            'entry_time' => 'date',
            'exit_time' => 'nullable|date',
            'entry_date' => 'date',
            'notes' => 'nullable|string'
        ]);

        $entry->update($request->all());
        return response()->json($entry->load(['vendor', 'box']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $entry = Entry::findOrFail($id);
        $entry->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get today's entries.
     */
    public function today()
    {
        // Buscar dados no banco principal para check-in público
        $entries = DB::connection('main')->table('entries')
            ->join('vendors', 'entries.vendor_id', '=', 'vendors.id')
            ->join('boxes', 'entries.box_id', '=', 'boxes.id')
            ->whereDate('entries.entry_date', Carbon::today())
            ->orderBy('entries.entry_time', 'desc')
            ->select(
                'entries.*',
                'vendors.name as vendor_name',
                'vendors.food_type as vendor_food_type',
                'boxes.number as box_number',
                'boxes.location as box_location',
                'boxes.name as box_name'
            )
            ->get()
            ->map(function($entry) {
                // Converter para formato esperado pela API
                return (object) [
                    'id' => $entry->id,
                    'vendor_id' => $entry->vendor_id,
                    'box_id' => $entry->box_id,
                    'entry_time' => $entry->entry_time,
                    'exit_time' => $entry->exit_time,
                    'entry_date' => $entry->entry_date,
                    'notes' => $entry->notes,
                    'vendor' => (object) [
                        'name' => $entry->vendor_name,
                        'food_type' => $entry->vendor_food_type
                    ],
                    'box' => (object) [
                        'number' => $entry->box_number,
                        'location' => $entry->box_location,
                        'name' => $entry->box_name
                    ]
                ];
            });
            
        return response()->json($entries);
    }
}
