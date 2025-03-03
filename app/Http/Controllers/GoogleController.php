<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Ensure this is imported
use App\Models\Notification; // Import Notification model
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
            $googleAvatarUrl = $googleUser->getAvatar(); // Get Google profile picture

            // Check if the user already exists in the database
            $user = User::where('email', $googleUser->getEmail())->first();
    
            // Define local path for storing the image
            $filename = time() . '.jpg'; // Unique filename based on timestamp
            $filepath = public_path('uploads/id_pictures/' . $filename);
    
            // Download and save the Google profile picture locally
            if ($googleAvatarUrl) {
                $imageContents = file_get_contents($googleAvatarUrl); // Fetch image from Google
                file_put_contents($filepath, $imageContents); // Save image locally
            }

            if (!$user) {
                // If the user does not exist, create a new user
                $user = User::create([
                    'name' => $googleUser ->getName(),
                    'last_name' => $googleUser ->getName(), // You might want to split this if you have a separate last name
                    'email' => $googleUser ->getEmail(),
                    'password' => bcrypt(Str::random(16)),// Use Str::random() to generate a random password
                    // You can add other fields if necessary
                    'id_picture' => $googleUser->getAvatar(), //takes the google profile :O
                ]);

                  // Log the user in
            Auth::login($user);

            // Redirect to a form to collect the contact number
            return redirect()->route('google.phone', ['user' => $user->id]);
        }


          // Update id_picture if the Google profile picture changes
          if ($user->id_picture !== $googleUser->getAvatar()) {
            $user->id_picture = $googleUser->getAvatar();
            $user->save();
        }


        // Log the user in if they already exist
        Auth::login($user);

        session()->flash('success', 'You have successfully logged in!');


        Notification::create([
            'user_id' => $user->id,
            'message' => 'You have successfully logged in using Google.',
            'is_read' => false,
        ]);

        // Check if the user is an admin and redirect accordingly
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
        } else {
            return redirect()->route('user.dashboard'); // Change 'dashboard' to your desired route
        }

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
        return redirect()->route('user.dashboard'); // Change 'dashboard' to your desired route
    }
}