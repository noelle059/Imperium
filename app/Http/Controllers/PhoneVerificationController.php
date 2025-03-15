<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class PhoneVerificationController extends Controller
{
    public function sendOtp(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        if (!$user->contact_number) {
            return back()->with('error', 'No contact number found. Please update your profile.');
        }

        $otp = rand(100000, 999999);
        Session::put('phone_otp', $otp);
        Session::put('contact_number', $user->contact_number);

        // Send OTP via Textbelt using Laravel's HTTP client
        $response = Http::post('https://textbelt.com/text', [
            'phone' => $user->contact_number,
            'message' => "Your verification code is: $otp",
            'key' => 'textbelt' // Free key allows 1 SMS per day
        ]);

        $body = $response->json();

        if ($body['success']) {
            return redirect()->route('auth.verify-phone.verifyOtp')->with('success', 'OTP sent to your registered contact number.');
        } else {
            return back()->with('error', 'Failed to send OTP. Error: ' . ($body['error'] ?? 'Unknown error.'));
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ]);

        if (Session::get('phone_otp') == $request->otp) {
            $user = Auth::user();
            $user->phone_verified_at = now();
            $user->email_verified_at = now(); // Mark email as verified
            $user->save();

            Session::forget('phone_otp');
            Session::forget('contact_number');

            return redirect()->route('dashboard')->with('success', 'Phone and email verified!');
        }

        return back()->with('error', 'Invalid OTP. Try again.');
    }
}
