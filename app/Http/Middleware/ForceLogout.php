<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ForceLogout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // If force logout is triggered for this user
            if (Cache::get('force_logout_' . $user->id)) {
                Auth::logout();
                Cache::forget('force_logout_' . $user->id); // Remove logout flag

                // Redirect to home with logout message
                return redirect()->route('home')->with('alert', 'You have been logged out because you signed in on another device.');
            }
        }

        return $next($request);
    }
}

