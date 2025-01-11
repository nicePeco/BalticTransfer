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
}
