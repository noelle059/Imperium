<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;

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


            // Check if anything has changed before updating
            $isUpdated = false;

            // Check each field and compare with the current subject values
            if ($account->rfid_uid !== $validated['rfid_uid']) {
                $account->rfid_uid = $validated['rfid_uid'];
                $isUpdated = true;
            }
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
}
