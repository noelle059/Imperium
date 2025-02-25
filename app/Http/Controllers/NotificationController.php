<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::whereNull('deleted_at')->get();
        return response()->json($notifications);
    }

    public function markAllRead()
    {
        Notification::whereNull('deleted_at')->update(['deleted_at' => now()]);
        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function softDelete($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->delete(); // Soft delete
            return response()->json(['message' => 'Notification removed']);
        }
        return response()->json(['error' => 'Notification not found'], 404);
    }
    
}