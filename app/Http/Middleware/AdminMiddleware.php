<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in, redirect to homepage
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        // If user is logged in but not an admin, redirect to homepage
        if (!Auth::user()->is_admin) {
            return redirect('/')->with('error', 'You do not have access to this page.');
        }

        return $next($request);
    }
}
