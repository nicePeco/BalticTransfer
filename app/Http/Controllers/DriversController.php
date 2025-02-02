<?php

namespace App\Http\Controllers;

use App\Models\CarPhoto;
use App\Models\Drivers;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();
        $yearStart = now()->startOfYear()->toDateString();
        $yearEnd = now()->endOfYear()->toDateString();

        $weeklyPayments = Payment::where('driver_id', $driver->id)
            ->whereBetween('week_start', [$weekStart, $weekEnd])
            ->get();

        $monthlyPayments = Payment::where('driver_id', $driver->id)
            ->whereBetween('week_start', [$monthStart, $monthEnd])
            ->get();

        $yearlyPayments = Payment::where('driver_id', $driver->id)
            ->whereBetween('week_start', [$yearStart, $yearEnd])
            ->get();

        $totalEarningsWeekly = $weeklyPayments->sum('total_earnings');
        $totalCompanyShareWeekly = $weeklyPayments->sum('company_share');

        $totalEarningsMonthly = $monthlyPayments->sum('total_earnings');
        $totalCompanyShareMonthly = $monthlyPayments->sum('company_share');

        $totalEarningsYearly = $yearlyPayments->sum('total_earnings');
        $totalCompanyShareYearly = $yearlyPayments->sum('company_share');

        return view('driver.payment', compact(
            'weeklyPayments',
            'totalEarningsWeekly',
            'totalCompanyShareWeekly',
            'totalEarningsMonthly',
            'totalCompanyShareMonthly',
            'totalEarningsYearly',
            'totalCompanyShareYearly'
        ));
    }

    public function showVerificationForm()
    {
        return view('driver.verify');
    }

    public function submitVerification(Request $request)
    {
        $request->validate([
            'license_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'license_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $driver = Auth::user()->driver;

        if (!$driver) {
            return redirect()->route('driver.dashboard')->withErrors('Driver profile not found.');
        }

        if ($request->hasFile('license_front')) {
            if ($driver->license_front) {
                Storage::disk('public')->delete($driver->license_front);
            }
            $frontPath = $request->file('license_front')->store('licenses', 'public');
            $driver->license_front = $frontPath;
        }

        if ($request->hasFile('license_back')) {
            if ($driver->license_back) {
                Storage::disk('public')->delete($driver->license_back);
            }
            $backPath = $request->file('license_back')->store('licenses', 'public');
            $driver->license_back = $backPath;
        }

        $driver->verification_status = 'pending';
        $driver->save();

        return redirect()->route('driver.dashboard')->with('success', 'Verification updated! Awaiting admin approval.');
    }

    public function waitingPage()
    {
        return view('driver.waiting');
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
        $driver = Auth::user()->driver;

        if ($driver) {
            if ($driver->license_front) {
                Storage::disk('public')->delete($driver->license_front);
            }
            if ($driver->license_back) {
                Storage::disk('public')->delete($driver->license_back);
            }
    
            $driver->delete();
        }
    
        return redirect('/')->with('success', 'Your account has been deleted.');
    }

    public function showDriverProfile()
    {
        
    }
}
