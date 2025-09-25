<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\Vendor;
use App\Models\Entry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function showCheckinForm($boxNumber)
    {
        $box = Box::where('number', $boxNumber)->firstOrFail();
        return view('checkin.form', compact('box'));
    }

    public function processCheckin(Request $request, $boxNumber)
    {
        $request->validate([
            'email' => 'required|email|exists:vendors,email'
        ]);

        $box = Box::where('number', $boxNumber)->firstOrFail();
        $vendor = Vendor::where('email', $request->email)->firstOrFail();

        $today = Carbon::today();
        
        // Procurar entrada ativa do vendedor hoje
        $activeEntry = Entry::where('vendor_id', $vendor->id)
            ->whereDate('entry_date', $today)
            ->whereNull('exit_time')
            ->first();

        if ($activeEntry) {
            // Check-out - registrar saída
            $activeEntry->update([
                'exit_time' => Carbon::now()->toTimeString()
            ]);

            return view('checkin.success', [
                'box' => $box,
                'vendor' => $vendor,
                'action' => 'checkout',
                'entry' => $activeEntry
            ]);
        } else {
            // Check-in - criar nova entrada
            $entry = Entry::create([
                'vendor_id' => $vendor->id,
                'box_id' => $box->id,
                'entry_date' => $today->toDateString(),
                'entry_time' => Carbon::now()->toTimeString(),
            ]);

            return view('checkin.success', [
                'box' => $box,
                'vendor' => $vendor,
                'action' => 'checkin',
                'entry' => $entry
            ]);
        }
    }
}
