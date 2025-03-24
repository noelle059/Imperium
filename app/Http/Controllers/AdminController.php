<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;





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
            ->where('archive_status', 0)  // Only those with archive_status = 1
            ->paginate(10);  // Paginate 10 results per page

        // Return the view with the professors data
        return view('admin.adminAccounts', compact('admin_accounts'));
    }


    public function showProfessors()
    {
        // Get professors (non-admin users) where archive_status = 1 and paginate 10
        $professors = User::where('is_admin', false)  // Exclude admin users
            ->where('archive_status', 1)  // Only those with archive_status = 1
            ->paginate(10);  // Paginate 10 results per page

        // Return the view with the professors data
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
            if ($account->rfid_uid && $scannedRFID === 'a2aa1702') {
                $account->is_activated = 0; // Deactivate the professor
                $account->rfid_uid = null;  // Remove RFID
                $account->save();

                return redirect()->route('accounts')
                    ->with('success', 'Professor has been deactivated successfully!');
            }

            // CASE 2: Professor tries to register using Super Admin RFID → Block it
            if (!$account->rfid_uid && $scannedRFID === 'a2aa1702') {
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
    Log::info('Archiving user ID: ' . $id); // Debugging log

    $account = User::find($id);

    if (!$account) {
        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }

    $account->archive_status = 1; // Set archive_status to 1 (Archived)
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
            'id_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure it's a valid image file
        ]);

        // Handle file upload
        if ($request->hasFile('id_picture')) {
            $image = $request->file('id_picture');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/id_pictures'), $imageName); // Save to public/uploads/id_pictures
        } else {
            $imageName = 'default-profile.png'; // Default image if no upload
        }

        // Create new admin user
        User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password),
            'is_admin' => 1,
            'id_picture' => $imageName, // Save the filename in the database
            'archive_status' =>0,
        ]);

        return redirect()->back()->with('success', 'Admin account created successfully!');
    }


    public function admin_update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'contact_number' => 'required|string|max:20',
        ]);

        $admin = User::findOrFail($request->id);
        $admin->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->back()->with('success', 'Admin updated successfully!');
    }



    public function destroy(Request $request)
    {
        $admin = User::findOrFail($request->id);

        // Update archive_status to 0 instead of deleting
        $admin->update(['archive_status' => 1]);

        return response()->json(['success' => true, 'message' => 'Admin archived successfully!']);
    }




}
