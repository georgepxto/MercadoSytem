<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with(['vendor', 'box'])->get();
        return response()->json($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'box_id' => 'required|exists:boxes,id',
            'day_of_week' => 'required|in:segunda,terça,quarta,quinta,sexta,sábado,domingo',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'active' => 'boolean'
        ]);

        $schedule = Schedule::create($request->all());
        return response()->json($schedule->load(['vendor', 'box']), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schedule = Schedule::with(['vendor', 'box'])->findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        $request->validate([
            'vendor_id' => 'exists:vendors,id',
            'box_id' => 'exists:boxes,id',
            'day_of_week' => 'in:segunda,terça,quarta,quinta,sexta,sábado,domingo',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i|after:start_time',
            'active' => 'boolean'
        ]);

        $schedule->update($request->all());
        return response()->json($schedule->load(['vendor', 'box']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get schedules by vendor.
     */
    public function byVendor($vendorId)
    {
        $schedules = Schedule::with(['box'])
            ->where('vendor_id', $vendorId)
            ->where('active', true)
            ->get();
            
        return response()->json($schedules);
    }

    /**
     * Get schedules by box.
     */
    public function byBox($boxId)
    {
        $schedules = Schedule::with(['vendor'])
            ->where('box_id', $boxId)
            ->where('active', true)
            ->get();
            
        return response()->json($schedules);
    }
}
