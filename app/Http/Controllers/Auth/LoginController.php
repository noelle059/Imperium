<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Check if user is archived
            if ($this->is_archived($user)) {
                Auth::logout();
                return back()->withInput($request->only('email'))->with('alert', 'Your account has been deactivated and cannot log in.');
            }
    
            // Get the current session ID
            $currentSessionId = session()->getId();
            
            // Check if there's a previous session and log it out
            $previousSessionId = \Illuminate\Support\Facades\Cache::get('user_session_' . $user->id);
            if ($previousSessionId && $previousSessionId !== $currentSessionId) {
                \Illuminate\Support\Facades\Session::getHandler()->destroy($previousSessionId);
            }
    
            // Store the new session ID
            \Illuminate\Support\Facades\Cache::put('user_session_' . $user->id, $currentSessionId, now()->addHours(5));
    
            // Create a login notification
            Notification::create([
                'user_id' => $user->id,
                'message' => 'You have successfully logged in.',
                'is_read' => false,
            ]);
    
            session()->flash('success', 'You have successfully logged in!');
    
            return $user->is_admin ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
        }
    
        return back()->withInput($request->only('email'))->with('alert', 'Invalid Email or password. Please try again.');
    }
    
    


    private function is_archived($user)
    {
        return $user->archive_status == 0;
    }

    private function getLoginNotificationMessage($user)
    {
        // Customize the message based on is_admin attribute
        if ($user->is_admin) {
            return 'Welcome back, Admin! You have new updates to review.';
        } else {
            return 'Welcome back! Enjoy your time.';
        }
    }

    private function forceLogoutPreviousSessions($user)
{
    $currentSession = session()->getId();
    $storedSession = \Illuminate\Support\Facades\Cache::get('user_session_' . $user->id);

    // If a different session exists, log the user out
    if ($storedSession && $storedSession !== $currentSession) {
        Auth::logout();
        return redirect()->route('home')->with('alert', 'You have been logged out because you signed in on another device.');
    }
}

}
