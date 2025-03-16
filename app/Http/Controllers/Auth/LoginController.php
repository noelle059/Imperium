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

            // Create a user-specific login notification
            $message = $this->getLoginNotificationMessage($user);
            Notification::create([
                'user_id' => $user->id,
                'message' => $message,
                'is_read' => false,
            ]);

            // Set a session flash message for successful login
            session()->flash('success', 'You have successfully logged in!');

            // Redirect based on user role
            return $user->is_admin ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
        }

        // If authentication fails, redirect back with an alert
        return back()->withInput($request->only('email'))->with('alert', 'Invalid Email or password. Please try again.')->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The password is incorrect. Please try again.',
        ]);
    }

    private function is_archived($user)
    {
        return $user->is_archived == 1;
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
}
