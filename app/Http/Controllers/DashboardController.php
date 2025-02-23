<?php
namespace App\Http\Controllers;

use App\Models\Room;
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
                    // Second tap: Update time-out
                    $history->update(['time_out' => Carbon::now()]);

                    // Update room status back to Available
                    $room->update([
                        'status' => 'Available',
                        'controller' => false,
                        'time_in' => null,
                        'professor_name' => null
                    ]);

                    return response()->json([
                        'access_state' => false,
                        'room' => $room  // ✅ Include room in response
                    ]);
                } else {
                    $now = Carbon::now()->format('H:i:s');

                    // First tap: Log time-in
                    RoomHistory::create([
                        'room_name' => '1',
                        'professor_name' => $user->name,
                        'time_in' => $now,
                        'time_out' => null
                    ]);

                    // Update room status to Occupied
                    $room->update([
                        'professor_name' => $user->name,
                        'status' => 'Occupied',
                        'time_in' => $now,
                        'controller' => true,
                    ]);

                    return response()->json([
                        'access_state' => true,
                        'room' => $room  // ✅ Include room in response
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
