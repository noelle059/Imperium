<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }

    public function destroy(Request $request)
{
    Auth::guard('web')->logout(); // Logs out the user

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); // 🔥 Redirect to homepage after logout
}

}
