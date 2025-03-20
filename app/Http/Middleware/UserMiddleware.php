<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in, redirect to homepage
        if (!Auth::check()) {
            return redirect('home')->with('error', 'Unauthorized access.');
        }

        // If an admin tries to access user pages, redirect to homepage
        if (Auth::user()->is_admin) {
            return redirect('home')->with('error', 'You do not have access to this page.');
        }

        return $next($request);
    }
}
