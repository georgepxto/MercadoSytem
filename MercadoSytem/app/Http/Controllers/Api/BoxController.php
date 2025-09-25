<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Buscar boxes do banco principal
        $boxesQuery = DB::connection('main')->table('boxes');
        
        // Se receber ?available=1, retorna só os boxes disponíveis
        if ($request->has('available') && $request->available == 1) {
            $boxesQuery->where('available', true);
        }

        $boxes = $boxesQuery->get();
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

        // Criar box no banco principal
        $boxId = DB::connection('main')->table('boxes')->insertGetId([
            'name' => $request->name,
            'number' => $request->number,
            'location' => $request->location,
            'description' => $request->description,
            'available' => $request->boolean('available', true),
            'monthly_price' => $request->monthly_price,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Buscar box criado para retornar
        $box = DB::connection('main')->table('boxes')->where('id', $boxId)->first();
        
        return response()->json($box, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $box = DB::connection('main')->table('boxes')->where('id', $id)->first();
        
        if (!$box) {
            return response()->json(['message' => 'Box não encontrado'], 404);
        }
        
        return response()->json($box);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Verificar se box existe no banco principal
        $existingBox = DB::connection('main')->table('boxes')->where('id', $id)->first();
        if (!$existingBox) {
            return response()->json(['message' => 'Box não encontrado'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'available' => 'boolean',
            'monthly_price' => 'nullable|numeric|min:0'
        ]);

        // Atualizar no banco principal
        DB::connection('main')->table('boxes')->where('id', $id)->update([
            'name' => $request->name,
            'number' => $request->number,
            'location' => $request->location,
            'description' => $request->description,
            'available' => $request->boolean('available', true),
            'monthly_price' => $request->monthly_price,
            'updated_at' => now()
        ]);

        // Buscar box atualizado
        $updatedBox = DB::connection('main')->table('boxes')->where('id', $id)->first();
        
        return response()->json($updatedBox);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Verificar se box existe no banco principal
        $box = DB::connection('main')->table('boxes')->where('id', $id)->first();
        if (!$box) {
            return response()->json(['message' => 'Box não encontrado'], 404);
        }

        // Verificar se há entradas relacionadas
        $entriesCount = DB::connection('main')->table('entries')->where('box_id', $id)->count();
        if ($entriesCount > 0) {
            return response()->json([
                'error' => 'Não é possível excluir este box pois ele possui histórico de entradas.',
                'entries_count' => $entriesCount
            ], 422);
        }

        // Excluir box do banco principal
        DB::connection('main')->table('boxes')->where('id', $id)->delete();
        
        return response()->json(['message' => 'Box excluído com sucesso.'], Response::HTTP_OK);
    }
}