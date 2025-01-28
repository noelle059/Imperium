<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    
        // Verify the email
        if ($user->markEmailAsVerified()) {
            // Manually update emails_verified_at
            $user->emails_verified_at = now(); // This should set the timestamp
            $user->save(); // Save the user to the database
    
            Log::info('User  email verified successfully: ' . $user->email);
        } else {
            Log::error('Failed to mark email as verified for user: ' . $user->email);
        }
    
        // Redirect to dashboard
        return redirect($this->redirectTo)->with('status', 'Email verified successfully!');
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectTo)
            : view('auth.verify');
    }
}