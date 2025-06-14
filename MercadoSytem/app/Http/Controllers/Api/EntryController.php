<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = Entry::with(['vendor', 'box'])
            ->orderBy('entry_date', 'desc')
            ->orderBy('entry_time', 'desc')
            ->get();
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
        $entry = Entry::findOrFail($id);
        
        if ($entry->exit_time) {
            return response()->json(['message' => 'Saída já registrada'], Response::HTTP_BAD_REQUEST);
        }

        $entry->update(['exit_time' => Carbon::now()]);
        
        return response()->json($entry->load(['vendor', 'box']));
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
        $entries = Entry::with(['vendor', 'box'])
            ->whereDate('entry_date', Carbon::today())
            ->orderBy('entry_time', 'desc')
            ->get();
            
        return response()->json($entries);
    }
}
