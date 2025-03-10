<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;


use Illuminate\Foundation\Validation\ValidatesRequests;

class FloorController extends Controller
{
    use ValidatesRequests;
    public function showFloor()
    {
        // Get professors (admin users) where archive_status = 1 and paginate 10
        $show_floor = Floor::where('archive_status', 1)  // Only those with archive_status = 1
            ->paginate(10);  // Paginate 10 results per page

        // Return the view with the professors data
        return view('admin.floor', compact('show_floor'));
    }


    public function addFloor(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'floor_name' => 'required',  // Make sure 'floor_name' is required
        ]);

        // Check if the floor_name already exists in the database
        $existingFloor = Floor::where('floor_name', $request->input('floor_name'))->first();

        if ($existingFloor) {
            // If the floor name exists, redirect back with an error message
            return redirect()->back()->with('error', 'A floor level with this name already exists.');
        }

        // Create and save the new floor if it does not exist
        $floor_name = new Floor();
        $floor_name->floor_name = $request->input('floor_name');
        $floor_name->save();

        return redirect('/admin/floor')->with('success', 'Floor Level Added Successfully');
    }


    public function updateFloor(Request $request, $id)
    {
        // Validate the incoming request
        $this->validate($request, [
            'floor_name' => 'required',  // Make sure 'floor_name' is required
        ]);

        // Check if the floor_name already exists in the database
        $existingFloor = Floor::where('floor_name', $request->input('floor_name'))->first();

        if ($existingFloor) {
            // If the floor name exists, redirect back with an error message
            return redirect()->back()->with('error', 'A floor level with this name already exists.');
        }

        // Find the floor by id
        $floor = Floor::find($id);

        // Update the floor name
        $floor->floor_name = $request->input('floor_name');
        $floor->save();

        return redirect('/admin/floor')->with('success', 'Floor Level Updated Successfully');
    }



    public function removeFloor($id)
    {
        // Find the floor by id
        $floor = Floor::find($id);

        // Set the archive_status to 0
        $floor->archive_status = 0;
        $floor->save();

        // Return a success response in JSON format
        return response()->json(['success' => true, 'message' => 'Floor Level Removed Successfully']);
    }
}
