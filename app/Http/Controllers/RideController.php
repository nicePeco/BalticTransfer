<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\offers;
use App\Notifications\DriverAppliedNotification;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'price' => 'required|numeric|min:0',
        ]);

        $driver = Auth::user()->driver;

        if (!$driver) {
            abort(403, 'Only drivers can apply for rides.');
        }

        $existingRide = Ride::where('driver_id', $driver->id)
            ->where('offer_id', $request->offer_id)
            ->first();

        if ($existingRide) {
            return redirect()->back()->with('error', 'You have already applied for this ride.');
        }

        Ride::create([
            'driver_id' => $driver->id,
            'offer_id' => $request->offer_id,
            'price' => $request->price,
        ]);

        return redirect()->route('offers.show', $request->offer_id)
            ->with('success', 'You have successfully applied for this ride.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Ride $ride)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ride $ride)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ride $ride)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ride = Ride::findOrFail($id);

        if (Auth::user()->driver->id !== $ride->driver_id) {
            abort(403, 'You are not authorized to cancel this ride.');
        }
    
        $offer = $ride->offer;
    
        if ($offer->accepted_driver_id) {
            if ($offer->accepted_driver_id === $ride->driver_id) {
                $offer->delete();
                return redirect()->route('driver.applications')->with('success', 'Offer successfully canceled.');
            }
    
            return redirect()->route('driver.applications')->with('error', 'You cannot cancel an accepted ride.');
        }
    
        $ride->delete();
    
        return redirect()->route('driver.applications')->with('success', 'Ride application successfully canceled.');

    }

    public function myApplications()
    {
        $driver = Auth::user()->driver;

        if (!$driver) {
            abort(403, 'Only drivers can view their applications.');
        }

        $rides = Ride::with('offer')
            ->where('driver_id', $driver->id)
            ->whereHas('offer', function ($query) {
                $query->where('status', '!=', 'completed');
            })
            ->get();

        return view('driver.applications', compact('rides'));
    }
}
