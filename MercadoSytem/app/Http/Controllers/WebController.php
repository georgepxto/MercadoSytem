<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Box;
use App\Models\Entry;
use App\Models\Schedule;
use Carbon\Carbon;

class WebController extends Controller
{
    public function index()
    {
        $todayEntries = Entry::with(['vendor', 'box'])
            ->whereDate('entry_date', Carbon::today())
            ->orderBy('entry_time', 'desc')
            ->get();
            
        $totalVendors = Vendor::where('active', true)->count();
        $totalBoxes = Box::where('available', true)->count();
        $activeEntries = Entry::whereDate('entry_date', Carbon::today())
            ->whereNull('exit_time')
            ->count();
            
        return view('dashboard', compact('todayEntries', 'totalVendors', 'totalBoxes', 'activeEntries'));
    }

    public function vendors()
    {
        $vendors = Vendor::with(['schedules.box'])->get();
        return view('vendors', compact('vendors'));
    }

    public function boxes()
    {
        $boxes = Box::with(['schedules.vendor'])->get();
        return view('boxes', compact('boxes'));
    }

    public function entries()
    {
        $entries = Entry::with(['vendor', 'box'])
            ->orderBy('entry_date', 'desc')
            ->orderBy('entry_time', 'desc')
            ->paginate(20);
        return view('entries', compact('entries'));
    }

    public function checkin()
    {
        $vendors = Vendor::where('active', true)->get();
        $boxes = Box::where('available', true)->get();
        return view('checkin', compact('vendors', 'boxes'));
    }
}
