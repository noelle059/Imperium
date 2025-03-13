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
            $googleUser = Socialite::driver('google')->user();
            $googleAvatarUrl = $googleUser->getAvatar(); // Get latest Google profile picture
    
            // Check if the user already exists in the database
            $user = User::where('email', $googleUser->getEmail())->first();
    
            if (!$user) {
                // If the user does not exist, create a new user and save the profile picture
                $filename = time() . '.jpg'; // Unique filename
                $filepath = public_path('uploads/id_pictures/' . $filename);
    
                // Download and save Google profile picture
                if ($googleAvatarUrl) {
                    $imageContents = file_get_contents($googleAvatarUrl);
                    file_put_contents($filepath, $imageContents);
                }
    
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'last_name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)), // Generate random password
                    'id_picture' => 'uploads/id_pictures/' . $filename, // Save local path
                    'is_archived' => 0, // Ensure new users are not archived by default
                ]);
            } else {
                // Prevent login if the user is archived
                if ($user->is_archived == 1) {
                    return redirect()->route('login')->with('alert', 'Your account has been deactivated and cannot log in.');
                }
    
                // Check if the stored id_picture is different from the new one
                if (!$user->id_picture || !str_contains($user->id_picture, md5($googleAvatarUrl))) {
                    $filename = md5($googleAvatarUrl) . '.jpg'; // Generate filename based on avatar hash
                    $filepath = public_path('uploads/id_pictures/' . $filename);
    
                    // Download and update only if changed
                    if ($googleAvatarUrl) {
                        $imageContents = file_get_contents($googleAvatarUrl);
                        file_put_contents($filepath, $imageContents);
                    }
    
                    // Update only if the image is different
                    $user->id_picture = 'uploads/id_pictures/' . $filename;
                    $user->save();
                }
            }
    
            // Log the user in
            Auth::login($user);
    
            session()->flash('success', 'You have successfully logged in!');
    
            Notification::create([
                'user_id' => $user->id,
                'message' => 'You have successfully logged in using Google.',
                'is_read' => false,
            ]);
    
            // Redirect based on user role
            return $user->is_admin 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('user.dashboard');
    
        } catch (Exception $e) {
            return redirect()->route('login')->with('alert', 'Unable to login using Google. Please try again.');
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