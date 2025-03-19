<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Hash;


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
    public function update(Request $request, $id)
    {
        try {
            // Find the subject by ID
            $account = User::findOrFail($id);

            // Validate the request data
            $validated = $request->validate([
                'rfid_uid' => 'required|string|max:255',
            ]);

            // Check if RFID UID already exists for another professor
            $existingAccount = User::where('rfid_uid', $validated['rfid_uid'])
            ->where('id', '!=', $id) // Exclude the current professor
            ->first();

            if ($existingAccount) {
                return redirect()->route('accounts')
                ->with('error', 'This RFID is already registered to another account!');
            }


            // Check if anything has changed before updating
            $isUpdated = false;

            // Check each field and compare with the current subject values
            if ($account->rfid_uid !== $validated['rfid_uid']) {
                $account->rfid_uid = $validated['rfid_uid'];
                $isUpdated = true;
            }

            // Set is_activated to 1 (indicating account is activated)
            $account->is_activated = 1;  // Mark account as activated
            $isUpdated = true;  // Mark as updated because we're changing the activation status

            // If nothing was updated, set a warning session message
            if (!$isUpdated) {
                return redirect()->route('accounts')
                    ->with('warning', 'No changes were made to the account no.');
            }
            // Save the changes to the database
            $account->save();

            // Redirect back to the subjects list with a success message
            return redirect()->route('accounts')
                ->with('success', 'Account No. updated successfully!');
        } catch (\Exception $e) {
            // In case of any error, set an error session message
            return redirect()->route('accounts')
                ->with('error', 'An error occurred while updating the subject: ' . $e->getMessage());
        }
    }


    /**
     * Archive a user account.
     */
    public function remove($id, Request $request)
    {
        $account = User::findOrFail($id); // Find the subject by ID

        $account->archive_status = 0; // Set archive_status to 0 (mark as removed)
        $account->save(); // Save changes

        return response()->json(['success' => true]); // Send success response
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
        ]);

        // Create new admin user
        User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password),
            'is_admin' => 1, 
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
        $admin->update(['archive_status' => 0]);
    
        return response()->json(['success' => true, 'message' => 'Admin archived successfully!']);
    }
    
    

}
