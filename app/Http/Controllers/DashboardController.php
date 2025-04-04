<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\ScheduleLog;
use App\Models\Schedule;
use App\Models\Classroom;
use App\Models\Notification;
use App\Models\Floor;
use App\Models\RoomHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Services\FirebaseService;



class DashboardController extends Controller
{

    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function AccountProfile()
    {
        return view('user.account-profile');
    }

    public function accountHistory()
    {
        return view('user.login-history'); // Ensure this view file exists
    }




    // public function updateDeviceState(Request $request, $classroomId, $deviceName)
    // {
    //     // Get the new state from the request (true or false)
    //     $firebaseState = filter_var($request->input('state'), FILTER_VALIDATE_BOOLEAN); // Cast to boolean

    //     // Firebase path
    //     $firebasePath = 'classrooms/' . $classroomId . '/devices/' . $deviceName;

    //     try {
    //         // Use FirebaseService to update the state in Firebase
    //         $firebaseService = app(FirebaseService::class);
    //         $firebaseService->setData($firebasePath, [
    //             'device_name' => $deviceName,
    //             'state' => $firebaseState, // Set the state in Firebase as a boolean
    //         ]);

    //         // Return response with the updated state
    //         return response()->json(['success' => true, 'state' => $firebaseState, 'message' => 'Device state updated successfully']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Failed to update device state', 'message' => $e->getMessage()], 500);
    //     }
    // }




    public function getDevices($classroom_id)
    {
        // Fetch the classroom with its devices relationship
        $classroom = Classroom::with('devices')->find($classroom_id);

        if (!$classroom) {
            return response()->json(['error' => 'Classroom not found'], 404);
        }

        $devicesWithState = [];
        $deviceIds = [];  // Array to store all the device IDs

        // Iterate through devices and get the state from Firebase
        foreach ($classroom->devices as $device) {
            try {
                // Use device_id to form the correct Firebase path
                $firebaseState = app(FirebaseService::class)->getData('classrooms/' . $classroom_id . '/devices/' . $device->id . '/state');

                // Ensure that state is either true or false (boolean)
                $device->state = ($firebaseState !== null) ? (bool)$firebaseState : false;
            } catch (\Exception $e) {
                $device->state = false; // Default state to false in case of an error
            }

            // Add the device with state to the array
            $devicesWithState[] = $device;
            // Collect the device_id in the array
            $deviceIds[] = $device->id;
        }

        // Return the devices along with the device IDs
        return response()->json([
            'devices' => $devicesWithState,
            'device_ids' => $deviceIds  // New key for device IDs
        ]);
    }


    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('alert', 'You must be logged in to access the user dashboard.');
        }

        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard')->with('alert', 'Admins cannot access the user dashboard.');
        }

        if (!Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')->with('alert', "Please verify your email before accessing the dashboard.");
        }

        $currentDateTime = Carbon::now('Asia/Manila')->format('l, F j, Y g:i A');

        $user = Auth::user();

        // Fetch only the floors and classrooms where the professor is scheduled
        $floors = Floor::whereHas('classrooms.schedules', function ($query) use ($user) {
            $query->where('user_id', $user->id); // Change 'professor_id' to 'user_id'
        })
            ->with([
                'classrooms' => function ($query) use ($user) {
                    $query->whereHas('schedules', function ($subQuery) use ($user) {
                        $subQuery->where('user_id', $user->id); // Change 'professor_id' to 'user_id'
                    })->where('archive_status', 1);
                },
                'classrooms.schedules' => function ($query) use ($user) {
                    $query->where('user_id', $user->id); // Change 'professor_id' to 'user_id'
                },
                'classrooms.schedules.scheduleLogs' => function ($query) {
                    $query->whereNull('end_time');
                },
                'classrooms.schedules.subject'
            ])
            ->where('archive_status', 1)
            ->get();

        return view('user.dashboard', compact('floors', 'currentDateTime'));
    }


    public function getRoomStatus()
    {
        $user = Auth::user();
        $room = Room::where('professor_name', $user->name)->first();

        if ($room) {
            return response()->json([
                'time_in' => $room->time_in,
            ]);
        }

        return response()->json([
            'error' => 'No room found for the current user.',
        ], 404);
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
                // Check if another user already controls the room
                if ($room->controller && $room->professor_name !== $user->name) {
                    return response()->json([
                        'error' => 'Room is already occupied by another user.'
                    ], 403);
                }

                // Check if the professor has an active time-in without a time-out
                $history = RoomHistory::where('room_name', '1')
                    ->where('professor_name', $user->name)
                    ->whereNull('time_out')
                    ->latest()
                    ->first();

                if ($history) {
                    // Second tap: Update time-out in Room History
                    $history->update(['time_out' => Carbon::now()]);

                    // Update room status to available
                    $room->update([
                        'status' => 'Available',
                        'controller' => false,
                        'time_in' => null,
                        'professor_name' => null
                    ]);

                    Notification::create([
                        'user_id' => $user->id,
                        'message' => 'You have left CL ' . $room->room_name,
                        'is_read' => false,
                    ]);

                    return response()->json([
                        'access_state' => false,
                        'room' => $room
                    ]);
                } else {
                    $now = Carbon::now()->format('H:i:s');

                    RoomHistory::create([
                        'room_name' => '1',
                        'professor_name' => $user->name,
                        'time_in' => $now,
                        'time_out' => null
                    ]);

                    Notification::create([
                        'user_id' => $user->id,
                        'message' => 'You have recently accessed CL ' . $room->room_name,
                        'is_read' => false,
                    ]);

                    $room->update([
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


    public function loginHistory()
{
    $logs = Notification::where('user_id', auth()->id())
        ->where('message', 'LIKE', '%logged in%') // Fetch only login messages
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('user.login-history', compact('logs'));
}



}
