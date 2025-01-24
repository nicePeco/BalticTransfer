<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->suspended_until) {
            if ($user->suspended_until === '2038-01-19 03:14:07') {
                Auth::logout();
                return redirect()->route('403')->with([
                    'suspension_type' => 'forever',
                ]);
            } elseif (now()->lessThan($user->suspended_until)) {
                Auth::logout();
                return redirect()->route('403')->with([
                    'suspension_type' => 'temporary',
                    'suspended_until' => $user->suspended_until->format('Y-m-d H:i:s'),
                ]);
            }
        }

        if ($user->driver && $user->driver->suspended_until) {
            if ($user->driver->suspended_until === '2038-01-19 03:14:07') {
                Auth::logout();
                return redirect()->route('403')->with([
                    'suspension_type' => 'forever',
                ]);
            } elseif (now()->lessThan($user->driver->suspended_until)) {
                Auth::logout();
                return redirect()->route('403')->with([
                    'suspension_type' => 'temporary',
                    'suspended_until' => $user->driver->suspended_until->format('Y-m-d H:i:s'),
                ]);
            }
        }
        

        return $next($request);
    }
}
