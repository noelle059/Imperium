<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Ensure this is imported
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;
use App\Models\Notification; // Import Notification model
use Exception;

class GoogleController extends Controller
{
    public function googlePage()
    {
        return Socialite::driver('google')->redirect();
    }

    
    public function googleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $googleAvatarUrl = $googleUser->getAvatar();
    
            // Find or create the user
            $user = User::where('email', $googleUser->getEmail())->first();
    
            if (!$user) {
                $filename = time() . '.jpg';
                $filepath = public_path('uploads/id_pictures/' . $filename);
    
                if ($googleAvatarUrl) {
                    $imageContents = file_get_contents($googleAvatarUrl);
                    file_put_contents($filepath, $imageContents);
                }
    
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'last_name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                    'id_picture' => 'uploads/id_pictures/' . $filename,
                    'archive_status' => 1,
                ]);
            } else {
                $user->refresh();
                if ($user->archive_status == 0) {
                    return redirect()->route('home')->with('alert', 'Your account has been deactivated and cannot log in.');
                }
            }
    
            // ✅ **Store a logout signal in cache (to be checked on all devices)**
            Cache::put('force_logout_' . $user->id, true, now()->addMinutes(5));
    
            // ✅ **Log out all other devices manually**
            DB::table('sessions')->where('user_id', $user->id)->delete();
    
            // ✅ **Log in user on the new session**
            Auth::login($user, true);
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            // ✅ **Notify user about login**
            Notification::create([
                'user_id' => $user->id,
                'message' => 'You have successfully logged in using Google on ' . now()->format('F j, Y \a\t h:i A') . '.',
                'is_read' => false,
            ]);
    
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