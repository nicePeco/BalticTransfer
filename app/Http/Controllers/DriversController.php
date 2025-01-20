<?php

namespace App\Http\Controllers;

use App\Models\Drivers;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DriversController extends Controller
{

    protected function create(array $data)
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $driver = Auth::user()->driver;

        if (!$driver) {
            abort(403, 'You are not a driver.');
        }

        return view('driver.dashboard', compact('driver'));
    }

    protected function registered(Request $request, $user)
    {
        
    }

    public function weeklySummary()
    {
        $driver = Auth::user()->driver;

        if (!$driver) {
            abort(403, 'You are not a driver.');
        }

        $weekStart = now()->startOfWeek()->toDateString();
        $weekEnd = now()->endOfWeek()->toDateString();

        $payments = Payment::where('driver_id', $driver->id)
            ->whereBetween('week_start', [$weekStart, $weekEnd])
            ->get();

        $totalEarnings = $payments->sum('total_earnings');
        $totalCompanyShare = $payments->sum('company_share');

        return view('driver.payment', compact('payments', 'totalEarnings', 'totalCompanyShare'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Drivers $drivers)
    {
        return view('');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drivers $drivers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drivers $drivers)
    {
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drivers $drivers)
    {
        //
    }

    public function showDriverProfile()
    {
        
    }
}
