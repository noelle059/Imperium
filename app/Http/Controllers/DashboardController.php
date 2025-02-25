<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Notification;
use App\Models\RoomHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('alert', 'You must be logged in to access the user dashboard.');
        }

        if (!Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')->with('alert', "Please verify your email before accessing the dashboard.");
        }

        $rooms = Room::all();
        return view('user.dashboard', compact('rooms'));
    }

    public function handleRfidScan(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $scannedRfid = $request->input('rfid_uid');
        $user = Auth::user();

        if ($user && $user->rfid_uid === $scannedRfid) {
            $room = Room::where('room_name', '1')->first();

            if ($room) {
                // Check if the professor has an active time-in without a time-out
                $history = RoomHistory::where('room_name', '1')
                    ->where('professor_name', $user->name)
                    ->whereNull('time_out')
                    ->latest()
                    ->first();

                if ($history) {
                    // Second tap: Update time-out in Room History
                    $history->update(['time_out' => Carbon::now()]);
                    // Update room status
                    $room->update([
                        'status' => 'Available',
                        'controller' => false,
                        'time_in' => null,
                        'professor_name' => null
                    ]);

                    Notification::create([ // For Notification
                        'user_id' => $user->id,
                        'message' => 'You have left CL ' . $room->room_name,
                        'is_read' => false,
                    ]);

                    return response()->json([
                        'access_state' => false,
                        'room' => $room  // ✅ Include room in response
                    ]);
                } else {
                    $now = Carbon::now()->format('H:i:s');

                    RoomHistory::create([ // For Room History
                        'room_name' => '1',
                        'professor_name' => $user->name,
                        'time_in' => $now,
                        'time_out' => null
                    ]);

                    Notification::create([ // For Notification
                        'user_id' => $user->id,
                        'message' => 'You have recently accessed CL ' . $room->room_name,
                        'is_read' => false,
                    ]);

                    $room->update([ // For room status
                        'professor_name' => $user->name,
                        'status' => 'Occupied',
                        'time_in' => $now,
                        'controller' => true,
                    ]);

                    return response()->json([
                        'access_state' => true,
                        'room' => $room
                    ]);
                }
            }
        }

        return response()->json(['error' => 'RFID does not match'], 400);
    }

    // public function getRooms()
    // {
    //     $rooms = Room::all();
    //     return response()->json($rooms);
    // }

}
