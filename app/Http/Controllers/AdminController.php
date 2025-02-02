<?php

namespace App\Http\Controllers;

use App\Models\CarPhoto;
use App\Models\Drivers;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::count();
        $totalDrivers = \App\Models\User::role('driver')->count();
        $totalRides = \App\Models\offers::count();

        return view('admin.dashboard', compact('totalUsers', 'totalDrivers', 'totalRides'));
    }

    public function viewUsers(Request $request)
    {
        $query = \App\Models\User::query();

        if ($request->filled('search')) {
            $query->where('id', $request->search);
        }

        $users = $query->get();

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

    public function viewDrivers(Request $request)
    {
        $query = \App\Models\Drivers::query();

        if ($request->filled('search')) {
            $query->where('id', $request->search);
        }

        $drivers = $query->get();

        foreach ($drivers as $driver) {
            $totalCompanyShare = $driver->total_company_share;
        }

        return view('admin.drivers.index', compact('drivers'));
    }

    public function editDriver($id)
    {
        $driver = \App\Models\Drivers::findOrFail($id);

        $totalCompanyShare = $driver->total_company_share;

        $driver->total_company_share = $totalCompanyShare;

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
            $ride->driver = \App\Models\Drivers::find($ride->accepted_driver_id);
            $ride->passenger = \App\Models\User::find($ride->offers_id);
            return $ride;
        });
        return view('admin.rides.index', compact('rides'));
    }

    public function editRide($id)
    {
        $ride = \App\Models\offers::findOrFail($id);
        $ride->driver = \App\Models\Drivers::find($ride->accepted_driver_id);
        $ride->passenger = \App\Models\User::find($ride->offers_id);

        $drivers = \App\Models\User::role('driver')->get();
        $passengers = \App\Models\User::all();

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

    public function suspendUser(Request $request, $id)
    {
        $request->validate([
            'duration' => 'required|string|in:forever,3_days,7_days,1_month',
        ]);

        $user = User::findOrFail($id);

        if (!$user) {
            return redirect()->route('admin.users')->withErrors('User not found.');
        }    

        $duration = match ($request->duration) {
            'forever' => '2038-01-19 03:14:07',
            '3_days' => now()->addDays(3),
            '7_days' => now()->addDays(7),
            '1_month' => now()->addMonth(),
        };

        $user->update(['suspended_until' => $duration]);

        return redirect()->route('admin.users')->with('success', 'User suspended successfully.');
    }

    public function unsuspendUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['suspended_until' => null]);

        return redirect()->route('admin.users')->with('success', 'User unsuspended successfully.');
    }

    public function hasPaid($id)
    {
        $driver = \App\Models\Drivers::findOrFail($id);

        $driver->update(['total_company_share' => 0]);

        return redirect()->route('admin.drivers.edit', $driver->id)->with('success', 'Driver has paid. Total company share reset to 0.');
    }

    public function hasNotPaid(Request $request, $id)
    {
        $driver = \App\Models\Drivers::findOrFail($id);

        $driver->update(['suspended_until' => '2038-01-19 03:14:07']);

        return redirect()->route('admin.drivers.edit', $driver->id)->with('error', 'Driver is now suspended. They must pay the company share to be unsuspended.');
    }

    public function unsuspendDriver($id)
    {
        $driver = \App\Models\Drivers::findOrFail($id);

        $driver->update(['suspended_until' => null]);
    
        return redirect()->route('admin.drivers.edit', $driver->id)->with('success', 'Driver has been unsuspended.');
    }

    public function viewDriverVerifications(Request $request)
    {
        $query = \App\Models\Drivers::where('verification_status', 'pending')->with('users');

        $drivers = $query->get();

        return view('admin.drivers.verifications', compact('drivers'));
    }

    public function updateDriverVerification(Request $request, $id)
    {
        $driver = Drivers::findOrFail($id);

        $driver->update([
            'verification_status' => $request->status,
            'admin_notes' => $request->admin_notes ?? null,
        ]);

        return redirect()->route('admin.driver-verifications')
            ->with('success', 'Verification updated successfully.');
    }

    public function downloadLicense($type, $id)
    {
        $driver = Drivers::findOrFail($id);
        $filePath = $type === 'front' ? $driver->license_front : $driver->license_back;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->withErrors('File not found.');
        }

        return Storage::disk('public')->download($filePath);
    }

    public function downloadCarPhoto($id)
    {
        $photo = CarPhoto::findOrFail($id);
        $filePath = $photo->photo_path;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->withErrors('File not found.');
        }

        return Storage::disk('public')->download($filePath);
    }

}
