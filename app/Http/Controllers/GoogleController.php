<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Ensure this is imported
use Exception;

class GoogleController extends Controller
{
    public function googlePage()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            // Get the user from Google
            $googleUser   = Socialite::driver('google')->user();

            // Check if the user already exists in the database
            $user = User::where('email', $googleUser ->getEmail())->first();

            if (!$user) {
                // If the user does not exist, create a new user
                $user = User::create([
                    'name' => $googleUser ->getName(),
                    'last_name' => $googleUser ->getName(), // You might want to split this if you have a separate last name
                    'email' => $googleUser ->getEmail(),
                    'password' => bcrypt(Str::random(16)), // Use Str::random() to generate a random password
                    // You can add other fields if necessary
                ]);

                // Log the user in
                Auth::login($user);

                // Redirect to a form to collect the contact number
                return redirect()->route('google.phone', ['user' => $user->id]);
            }

            // Log the user in if they already exist
            Auth::login($user);

            // Redirect to the desired route after login
            return redirect()->route('dashboard'); // Change 'dashboard' to your desired route

        } catch (Exception $e) {
            // Handle the error (e.g., log it, show an error message, etc.)
            return redirect()->route('login')->with('error', 'Unable to login using Google. Please try again.');
        }
    }

    public function showPhoneForm(Request $request)
    {
        $user = User::findOrFail($request->user);
        return view('auth.google-phone', compact('user'));
    }

    public function storePhone(Request $request)
    {
        $request->validate([
            'contact_number' => [
                'required',
                'string',
                'size:11',
                'regex:/^09[0-9]{9}$/',
                'unique:users', // Ensure the phone number is unique
            ],
        ]);

        // Update the user's contact number
        $user = User::findOrFail($request->user);
        $user->contact_number = $request->contact_number;
        $user->save();

        // Log the user in
        Auth::login($user);

        // Redirect to the desired route after login
        return redirect()->route('dashboard'); // Change 'dashboard' to your desired route
    }
}