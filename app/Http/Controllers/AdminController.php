<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;



use App\Models\Schedule;




class AdminController extends Controller
{
    public function index()
    {
        // Logic to display the admin dashboard
        return view('admin.dashboard');
    }

    public function manageUsers()
    {
        // Logic to manage users
        return view('admin.users.index');
    }



    public function showAdminAccount()
    {
        // Get professors (admin users) where archive_status = 1 and paginate 10
        $admin_accounts = User::where('is_admin', true)  // Exclude admin users
            ->where('archive_status', 1)  // Only those with archive_status = 1
            ->paginate(10);  // Paginate 10 results per page

        return view('admin.adminAccounts', compact('admin_accounts'));
    }


    public function showProfessors(Request $request)
    {
        $query = User::where('is_admin', false)
            ->where('archive_status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('rfid_uid', 'like', "%$search%");
            });
        }

        $professors = $query->paginate(10)->appends(['search' => $request->input('search')]);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.accounts', compact('professors'))->render()
            ]);
        }

        return view('admin.accounts', compact('professors'));
    }


    public function showRooms()
    {
        $rooms = Room::leftJoin('users', 'rooms.professor_name', '=', 'users.name')
            ->select('rooms.*', 'users.rfid_uid as account_no')
            ->get();

        return view('admin.classroom', compact('rooms'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, FirebaseService $firebaseService)
    {
        try {
            $scannedRFID = $firebaseService->getCurrentRFID();

            if (!$scannedRFID) {
                return redirect()->route('accounts')
                    ->with('error', 'No RFID scanned.');
            }

            $account = User::findOrFail($id);

            // CASE 1: Professor is already registered & admin scans super admin RFID → Deactivate first
            if ($account->rfid_uid && $scannedRFID === '23b28d14') {
                $account->is_activated = 0; // Deactivate the professor
                $account->rfid_uid = null;  // Remove RFID
                $account->save();

                return redirect()->route('accounts')
                    ->with('success', 'Professor has been deactivated successfully!');
            }

            // CASE 2: Professor tries to register using Super Admin RFID → Block it
            if (!$account->rfid_uid && $scannedRFID === '23b28d14') {
                return redirect()->route('accounts')
                    ->with('error', 'This RFID is reserved for the Super Admin. Please use a different card.');
            }

            if (!is_null($account->rfid_uid) && $account->rfid_uid !== $scannedRFID) {
                return redirect()->route('accounts')
                    ->with('error', 'Please deactivate the professor first before assigning a new RFID.');
            }

            // Validate the request data
            $validated = $request->validate([
                'rfid_uid' => 'required|string|max:255',
            ]);

            // Check if RFID UID is already registered to another professor
            $existingAccount = User::where('rfid_uid', $validated['rfid_uid'])
                ->where('id', '!=', $id)
                ->first();

            if ($existingAccount) {
                return redirect()->route('accounts')
                    ->with('error', 'This RFID is already registered to another account!');
            }

            // CASE 4: Assign RFID to professor only if there’s no previous RFID
            $account->rfid_uid = $validated['rfid_uid'];
            $account->is_activated = 1;
            $account->save();

            return redirect()->route('accounts')
                ->with('success', 'RFID updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('accounts')
                ->with('error', 'An error occurred while updating: ' . $e->getMessage());
        }
    }





    /**
     * Archive a user account.
     */
    public function remove($id, Request $request)
    {
        Log::info('Archiving user ID: ' . $id);

        $account = User::find($id);

        if (!$account) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        // Check if the professor has active schedules
        $activeSchedules = Schedule::where('user_id', $id)
            ->where('archive_status', 1)
            ->exists();

        if ($activeSchedules) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot archive this professor. They have active schedules.'
            ]);
        }

        $account->archive_status = 0;
        $account->save();

        return response()->json(['success' => true, 'message' => 'User archived successfully!']);
    }

    public function fetchRFID(FirebaseService $firebaseService)
    {
        try {
            $rfid = $firebaseService->getCurrentRFID();
            return response()->json(['success' => true, 'rfid' => $rfid]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }



    public function store(Request $request)
{
    // Validate inputs
    $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'contact_number' => 'required|string|max:20',
        'password' => 'required|min:6|confirmed',
        'id_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle file upload
    if ($request->hasFile('id_picture')) {
        $image = $request->file('id_picture');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/id_pictures'), $imageName);
    } else {
        $imageName = 'default-profile.png';
    }

    // Create new admin user
    $user = User::create([
        'name' => $request->name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'contact_number' => $request->contact_number,
        'password' => Hash::make($request->password),
        'is_admin' => 1,
        'id_picture' => $imageName,
        'archive_status' => 1,
    ]);

    // Create notification
    Notification::create([
        'user_id' => Auth::id(), // The logged-in admin who created the new admin
        'message' => 'Admin "' . $user->name . ' ' . $user->last_name . '" has been created by ' . Auth::user()->name . ' ' . Auth::user()->last_name . '.',
        'is_read' => false,
    ]);


    return redirect()->back()->with('success', 'Admin account created successfully!');
}


  public function admin_update(Request $request)
{
    $request->validate([
        'id' => 'required|exists:users,id',
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'id_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
    ]);

    $admin = User::findOrFail($request->id);

    // Prevent updating email if the user signed in with Google
    if (!$admin->google_id) {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
        ]);
        $admin->email = $request->email;
    }

    // ✅ Handle Image Upload
    if ($request->hasFile('id_picture')) {
        $image = $request->file('id_picture');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/id_pictures'), $imageName);

        // Delete old image if it exists (and it's not the default one)
        if ($admin->id_picture && $admin->id_picture !== 'default-profile.png') {
            $oldImagePath = public_path('uploads/id_pictures/' . $admin->id_picture);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }


        $admin->id_picture = $imageName; // ✅ Save new image name
    }

    // ✅ Update other admin details
    $admin->name = $request->name;
    $admin->last_name = $request->last_name;
    $admin->contact_number = $request->contact_number;
    $admin->save();


    Notification::create([
        'user_id' => Auth::id(), // The logged-in admin making the update
        'message' => 'Admin "' . $admin->name . ' ' . $admin->last_name . '" has been updated by ' . Auth::user()->name . ' ' . Auth::user()->last_name . '.',
        'is_read' => false,
    ]);





    return redirect()->back()->with('success', 'Admin updated successfully!');
}




public function destroy(Request $request)
{
    $admin = User::findOrFail($request->id);

    // Debugging - Check if the admin is found
    if (!$admin) {
        return response()->json(['success' => false, 'message' => 'Admin not found!']);
    }

    // Update archive_status to 0
    $updated = $admin->update(['archive_status' => 0]);

    // Debugging - Check if update was successful
    if (!$updated) {
        return response()->json(['success' => false, 'message' => 'Failed to archive admin.']);
    }

    // Ensure the logged-in admin exists before creating a notification
    if (Auth::check()) {
        Notification::create([
            'user_id' => Auth::id(), // Logged-in admin
            'message' => 'Admin "' . $admin->name . ' ' . $admin->last_name . '" has been archived by ' . Auth::user()->name . ' ' . Auth::user()->last_name . '.',
            'is_read' => false,
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Admin archived successfully!']);
}


public function loginLogs()
{
    $logs = Notification::whereHas('user', function ($query) {
        $query->where('is_admin', 1); // Fetch only admin logs
    })
    ->where(function ($query) {
        $query->where('message', 'LIKE', '%has been archived by%')
              ->orWhere('message', 'LIKE', '%has been updated by%')
              ->orWhere('message', 'LIKE', '%has been created by%');
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10); // Paginate properly

    return view('admin.login-logs', compact('logs'));
}







}
