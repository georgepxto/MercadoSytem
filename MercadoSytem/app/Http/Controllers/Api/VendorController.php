<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Buscar vendedores do banco principal
        $vendorsQuery = DB::connection('main')->table('vendors');
        
        // Se a query string tiver ?available=1, retorna apenas ativos
        if ($request->has('available') && $request->available == 1) {
            $vendorsQuery->where('active', true);
        }

        $vendors = $vendorsQuery->get();

        return response()->json($vendors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors',
            'phone' => ['required', 'string', 'regex:/^\(\d{2}\) \d{4,5}-\d{4}$/'],
            'food_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'has_cnpj' => 'boolean',
            'cnpj' => ['nullable', 'string', 'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', 'required_if:has_cnpj,true']
        ], [
            'phone.regex' => 'O telefone deve estar no formato (XX) XXXXX-XXXX para celular ou (XX) XXXX-XXXX para fixo',
            'cnpj.regex' => 'O CNPJ deve estar no formato XX.XXX.XXX/XXXX-XX',
            'cnpj.required_if' => 'O CNPJ é obrigatório quando "Possui CNPJ" está marcado'
        ]);

        $data = $request->all();
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
        }

        $vendor = Vendor::create($data);
        $vendor = Vendor::with(['schedules.box', 'entries'])->find($vendor->id);

        // "Achata" o box_number nos schedules deste vendor
        $array = $vendor->toArray();
        $array['schedules'] = collect($vendor->schedules)->map(function ($schedule) {
            $scheduleArray = is_array($schedule) ? $schedule : $schedule->toArray();
            $scheduleArray['box_number'] = isset($schedule->box) && $schedule->box ? $schedule->box->number : (isset($schedule['box']['number']) ? $schedule['box']['number'] : null);
            return $scheduleArray;
        })->toArray();

        return response()->json($array, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vendor = Vendor::with(['schedules.box', 'entries'])->findOrFail($id);

        // "Achata" o box_number nos schedules deste vendor
        $array = $vendor->toArray();
        $array['schedules'] = collect($vendor->schedules)->map(function ($schedule) {
            $scheduleArray = is_array($schedule) ? $schedule : $schedule->toArray();
            $scheduleArray['box_number'] = isset($schedule->box) && $schedule->box ? $schedule->box->number : (isset($schedule['box']['number']) ? $schedule['box']['number'] : null);
            return $scheduleArray;
        })->toArray();

        return response()->json($array);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:vendors,email,' . $id,
            'phone' => ['string', 'regex:/^\(\d{2}\) \d{4,5}-\d{4}$/'],
            'food_type' => 'string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'has_cnpj' => 'boolean',
            'cnpj' => ['nullable', 'string', 'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', 'required_if:has_cnpj,true']
        ], [
            'phone.regex' => 'O telefone deve estar no formato (XX) XXXXX-XXXX para celular ou (XX) XXXX-XXXX para fixo',
            'cnpj.regex' => 'O CNPJ deve estar no formato XX.XXX.XXX/XXXX-XX',
            'cnpj.required_if' => 'O CNPJ é obrigatório quando "Possui CNPJ" está marcado'
        ]);

        $data = $request->all();
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
        }

        $vendor->update($data);
        $vendor = Vendor::with(['schedules.box', 'entries'])->find($vendor->id);

        // "Achata" o box_number nos schedules deste vendor
        $array = $vendor->toArray();
        $array['schedules'] = collect($vendor->schedules)->map(function ($schedule) {
            $scheduleArray = is_array($schedule) ? $schedule : $schedule->toArray();
            $scheduleArray['box_number'] = isset($schedule->box) && $schedule->box ? $schedule->box->number : (isset($schedule['box']['number']) ? $schedule['box']['number'] : null);
            return $scheduleArray;
        })->toArray();

        return response()->json($array);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);

        // Verificar se há registros associados
        $hasSchedules = $vendor->schedules()->exists();
        $hasEntries = $vendor->entries()->exists();

        if ($hasSchedules || $hasEntries) {
            return response()->json([
                'message' => 'Não é possível excluir este vendedor pois ele possui registros associados (horários ou entradas).',
                'has_schedules' => $hasSchedules,
                'has_entries' => $hasEntries
            ], 400);
        }

        $vendor->delete();
        return response()->json([
            'message' => 'Vendedor excluído com sucesso!'
        ], Response::HTTP_OK);
    }
}