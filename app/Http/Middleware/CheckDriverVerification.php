<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDriverVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->driver) {
            $driver = Auth::user()->driver;
    
            if ($driver->verification_status !== 'approved') {
                return redirect()->route('driver.waiting')->with('error', 'Your account is under review.');
            }
        }
    
        return $next($request);
    }
}
