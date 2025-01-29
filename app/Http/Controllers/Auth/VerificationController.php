<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Import the User model

class VerificationController extends Controller
{
    use VerifiesEmails {
        verify as traitVerify; // Alias the original verify method
    }

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        // Log the verification attempt
        Log::info('Verification attempt for user ID: ' . $request->id);

        // Find the user
        $user = User::findOrFail($request->id);

        // Check if the email is already verified
        if ($user->hasVerifiedEmail()) {
            Log::info('User  email already verified: ' . $user->email);
            return redirect($this->redirectTo);
        }

        // Verify the email and set the verification timestamp
        if ($user->markEmailAsVerified()) {
            Log::info('User  email verified successfully: ' . $user->email);
        } else {
            Log::error('Failed to mark email as verified for user: ' . $user->email);
        }

        // Redirect to the dashboard
        return redirect($this->redirectTo)->with('status', 'Email verified successfully!');
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectTo)
            : view('auth.verify');
    }
}