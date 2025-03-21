<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthRedirectController extends Controller
{
    public function unauthorizedAccess(Request $request)
    {
        return redirect('/')->with('alert', 'You need to log in to access this page.');
    }
}

