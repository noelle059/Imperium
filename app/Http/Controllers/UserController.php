<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function insertUser (Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[\p{L} .\'-]+$/u',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.regex' => 'The name may only contain letters, spaces, hyphens, and apostrophes.',
        ]);
    
        // Create the user and hash the password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'emails_verified_at' => null, // No need to set this during registration
        ]);
    
        // Send email verification notification
        $user->sendEmailVerificationNotification();
    
        // Redirect to login with a message
        return redirect('/login')->with('message', 'User  created! Please verify your email.');
    }
}