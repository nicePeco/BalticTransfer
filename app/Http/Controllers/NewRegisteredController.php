<?php

namespace App\Http\Controllers;

use App\Models\Drivers;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class NewRegisteredController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('is_driver') && $request->is_driver) {
            $user->assignRole('driver');
            $user->role = 'DRIVER';
        } else {
            $user->assignRole('user');
            $user->role = 'USER';
        }

        $user->save();

        Auth::login($user);

        if ($user->role === 'DRIVER') {
            return redirect()->route('driver.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
