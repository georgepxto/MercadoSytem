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
            // Verificar se a entrada ativa é no mesmo box
            if ($activeEntry->box_id == $box->id) {
                // Check-out - registrar saída no mesmo box
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
                // Usuário tentando fazer check-in em box diferente - ERRO
                $activeBox = Box::find($activeEntry->box_id);
                
                return view('checkin.error', [
                    'box' => $box,
                    'vendor' => $vendor,
                    'activeBox' => $activeBox,
                    'activeEntry' => $activeEntry,
                    'message' => 'Você já possui check-in ativo em outro box. Realize o check-out primeiro.'
                ]);
            }
        } else {
            // Verificar se o box já está ocupado por outro usuário
            $boxOccupied = Entry::where('box_id', $box->id)
                ->whereDate('entry_date', $today)
                ->whereNull('exit_time')
                ->first();

            if ($boxOccupied) {
                // Box já está ocupado por outro usuário
                $occupyingVendor = Vendor::find($boxOccupied->vendor_id);
                
                return view('checkin.box-occupied', [
                    'box' => $box,
                    'vendor' => $vendor,
                    'occupyingVendor' => $occupyingVendor,
                    'occupyingEntry' => $boxOccupied,
                    'message' => 'Este box está em uso por outro fornecedor.'
                ]);
            }

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
