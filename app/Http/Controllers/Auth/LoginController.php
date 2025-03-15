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
        // Authentication passed...
        $user = Auth::user();

        // Create a user-specific login notification
        $message = $this->getLoginNotificationMessage($user);
        Notification::create([
            'user_id' => $user->id, // Ensure the notification is linked to the logged-in user
            'message' => $message, // Use the specific message for the user
            'is_read' => false,
        ]);

        // Set a session flash message for successful login
        session()->flash('success', 'You have successfully logged in!');

        // Redirect based on user role
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
        } else {
            return redirect()->route('user.dashboard'); // Redirect to user dashboard
        }
    }

    // If authentication fails, redirect back with an alert
    return back()->withInput($request->only('email'))->with('alert', 'Invalid Email or password. Please try again.')->withErrors([
        'email' => 'The provided credentials do not match our records.',
        'password' => 'The password is incorrect. Please try again.',
    ]);
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
