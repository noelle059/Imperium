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
}
