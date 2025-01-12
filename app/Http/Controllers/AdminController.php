<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::count();
        $totalDrivers = \App\Models\User::role('driver')->count();
        $totalRides = \App\Models\offers::count();

        return view('admin.dashboard', compact('totalUsers', 'totalDrivers', 'totalRides'));
    }

    public function viewUsers()
    {
        $users = \App\Models\User::all();
        return view('admin.users.index', compact('users'));
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function viewDrivers()
    {
        $drivers = \App\Models\User::role('driver')->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function editDriver($id)
    {
        $driver = \App\Models\User::findOrFail($id);

        if (!$driver->hasRole('driver')) {
            return redirect()->route('admin.drivers')->with('error', 'User is not a driver.');
        }

        return view('admin.drivers.edit', compact('driver'));
    }

    public function updateDriver(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'status' => 'required|string|in:active,inactive',
        ]);

        $driver = \App\Models\User::findOrFail($id);

        if (!$driver->hasRole('driver')) {
            return redirect()->route('admin.drivers')->with('error', 'User is not a driver.');
        }

        $driver->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.drivers')->with('success', 'Driver updated successfully.');
    }

    public function viewRides()
    {
        $rides = \App\Models\offers::all()->map(function ($ride) {
            $ride->driver = \App\Models\User::find($ride->accepted_driver_id);
            $ride->passenger = \App\Models\User::find($ride->offers_id);
            return $ride;
        });
        return view('admin.rides.index', compact('rides'));
    }

    public function editRide($id)
    {
        $ride = \App\Models\offers::findOrFail($id);
        $ride->driver = \App\Models\User::find($ride->accepted_driver_id);
        $ride->passenger = \App\Models\User::find($ride->offers_id);

        $drivers = \App\Models\User::role('driver')->get();
        $passengers = \App\Models\User::all(); // Assuming all users can be passengers

        return view('admin.rides.edit', compact('ride', 'drivers', 'passengers'));
    }

    public function updateRide(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,completed,canceled',
            'driver_id' => 'nullable|exists:users,id',
            'passenger_id' => 'nullable|exists:users,id',
        ]);

        $ride = \App\Models\offers::findOrFail($id);
        $ride->update([
            'status' => $request->status,
            'driver_id' => $request->driver_id,
            'passenger_id' => $request->passenger_id,
        ]);

        return redirect()->route('admin.rides')->with('success', 'Ride updated successfully.');
    }

}
