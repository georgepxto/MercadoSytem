<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Se receber ?available=1, retorna só os boxes disponíveis
        if ($request->has('available') && $request->available == 1) {
            $boxes = Box::with(['schedules.vendor', 'entries.vendor'])
                ->where('available', true)
                ->get();
        } else {
            $boxes = Box::with(['schedules.vendor', 'entries.vendor'])->get();
        }
        return response()->json($boxes);
    }

    /**
     * Store a newly created resource in storage.
     */    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|unique:boxes',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'available' => 'boolean',
            'monthly_price' => 'nullable|numeric|min:0'
        ]);

        $box = Box::create($request->all());
        return response()->json($box, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $box = Box::with(['schedules.vendor', 'entries.vendor'])->findOrFail($id);
        return response()->json($box);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $box = Box::findOrFail($id);        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|unique:boxes,number,' . $id,
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'available' => 'boolean',
            'monthly_price' => 'nullable|numeric|min:0'
        ]);

        $box->update($request->all());
        return response()->json($box);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $box = Box::findOrFail($id);

        $activeSchedules = $box->schedules()->where('active', true)->count();
        if ($activeSchedules > 0) {
            return response()->json([
                'error' => 'Não é possível excluir este box pois ele possui agendamentos ativos.',
                'active_schedules' => $activeSchedules
            ], 422);
        }

        $entriesCount = $box->entries()->count();
        if ($entriesCount > 0) {
            return response()->json([
                'error' => 'Não é possível excluir este box pois ele possui histórico de entradas.',
                'entries_count' => $entriesCount
            ], 422);
        }

        $box->delete();
        return response()->json(['message' => 'Box excluído com sucesso.'], Response::HTTP_OK);
    }
}