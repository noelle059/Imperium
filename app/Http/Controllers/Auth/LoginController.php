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
    
            // Get user IP, location, and device type
            $ip = $request->ip();
            $deviceType = $this->getDeviceType($request->header('User-Agent'));
            $location = $this->getLocationFromIp($ip);
    
            // Create a login notification with the IP, location, and device type
            Notification::create([
                'user_id' => $user->id,
                'message' => 'You have successfully logged in.',
                'is_read' => false,
                'ip_address' => $ip,
                'device_info' => $deviceType,
                'location' => $location,
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

    private function getDeviceType($userAgent)
    {
        if (preg_match('/(android|iphone|ipod|windows phone)/i', $userAgent)) {
            return 'Mobile';
        } elseif (preg_match('/(tablet|ipad|playbook|silk)/i', $userAgent)) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }

    private function getLocationFromIp($ip)
    {
        // You can use a service like "ipinfo.io" to get location data based on IP address
        // For simplicity, we're using this approach directly for Google login
        $json = file_get_contents("http://ipinfo.io/{$ip}/json"); // Fetch location data for the IP
        $data = json_decode($json, true);

        // Return a location or default message if location is not available
        return isset($data['city']) && isset($data['country']) ? $data['city'] . ', ' . $data['country'] : 'Unknown Location';
    }

    protected function authenticated(Request $request, $user)
    {
        // Store login event with IP, location, and device info
        Notification::create([
            'user_id' => $user->id,
            'message' => 'Successful login at ' . now(),
            'created_at' => now(),
            'ip_address' => $request->ip(), // Capturing the actual IP
            'device_info' => $this->getDeviceType($request->header('User-Agent')), // Device type
            'location' => $this->getLocationFromIp($request->ip()), // Location based on IP
        ]);
    }
}
