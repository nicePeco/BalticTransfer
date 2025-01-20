<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\offers;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = [];
        $appliedOffers = [];

        if (Auth::check() && Auth::user()->roles->contains('name', 'driver')) {
            $offers = Offers::with('rides')
                ->where(function ($query) {
                    $query->whereNull('accepted_driver_id')
                        ->orWhere('accepted_driver_id', Auth::user()->driver->id ?? null);
                })
                ->where('status', '!=', 'completed')
                ->orderBy('city_two', 'asc')
                ->get();

            $driverId = Auth::user()->driver->id ?? null;
            if ($driverId) {
                $appliedOffers = Ride::where('driver_id', $driverId)
                    ->pluck('offer_id')
                    ->toArray();
            }
        } else {
            $offers = Offers::with('rides')
                ->where('offers_id', Auth::id())
                ->where('status', '!=', 'completed')
                ->orderBy('city_two', 'asc')
                ->get();
        }

        return view('client.profile', compact('offers', 'appliedOffers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
