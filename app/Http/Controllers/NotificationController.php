<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                                     ->whereNull('deleted_at')
                                     ->get();
        return response()->json($notifications);
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
                    ->whereNull('deleted_at')
                    ->update(['deleted_at' => now()]);
        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function softDelete($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->first();
        if ($notification) {
            $notification->delete(); // Soft delete
            return response()->json(['message' => 'Notification removed']);
        }
        return response()->json(['error' => 'Notification not found'], 404);
    }

    public function loginLogs()
    {
        $logs = Notification::whereHas('user', function ($query) {
            $query->where('is_admin', 1); // Fetch only admin logs
        })->orderBy('created_at', 'desc')->get();

        return view('admin.login-logs', compact('logs'));
    }

    public function loginHistory()
{
    $userId = Auth::id(); // Get the currently authenticated user

    $notifications = Notification::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.login-history', compact('notifications'));
}


    
}
