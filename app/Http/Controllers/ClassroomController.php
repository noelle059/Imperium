<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\FirebaseService;
use App\Models\Classroom;
use App\Models\Floor;
use Barryvdh\DomPDF\Facade\Pdf;

class ClassroomController extends Controller
{
    use ValidatesRequests;
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }


    public function showClassroom()
    {
        // Fetch classrooms with the related devices (device count), and paginate results
        $classrooms = Classroom::withCount('devices')  // Count the devices for each classroom
            ->where('archive_status', 1)  // Only fetch classrooms where archive_status = 1
            ->paginate(10);

        // Fetch all floors to display in the dropdown
        $floors = Floor::all();

        // Pass classrooms and floors to the view
        return view('admin.classroom', compact('classrooms', 'floors'));
    }





    public function addClassroom(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'classroom_name' => 'required|unique:classrooms,classroom_name',  // Ensure the classroom name is unique in the database
            'floor_id' => 'required|exists:floors,id', // Ensure the floor exists in the floors table
        ]);

        // Retrieve the form input data
        $classroomName = $request->input('classroom_name');
        $floorId = $request->input('floor_id');

        // Check if the classroom already exists in the database
        $existingClassroomInDatabase = Classroom::where('classroom_name', $classroomName)->first();

        if ($existingClassroomInDatabase) {
            // If the classroom already exists in the database, return an error message
            return redirect()->route('show_classroom')->with('error', 'A classroom with this name already exists.');
        }

        // Save the classroom to the local database
        $classroom = new Classroom();
        $classroom->classroom_name = $classroomName;
        $classroom->floor_id = $floorId;
        $classroom->archive_status = 1;  // Default archive status
        $classroom->save();

        // Firebase path for the classroom
        $firebasePath = 'classrooms/' . $classroom->id; // Use the classroom ID to avoid name conflicts

        // Save the classroom data to Firebase (without floor_id and archive_status)
        $this->firebaseService->setData($firebasePath, [
            'classroom_name' => $classroomName,
        ]);

        // Redirect back with a success message
        return redirect()->route('show_classroom')->with('success', 'Classroom Added Successfully');
    }



    public function updateClassroom(Request $request, $id)
    {
        // Validate the incoming request
        $this->validate($request, [
            'classroom_name' => 'required|unique:classrooms,classroom_name,' . $id,  // Ensure the classroom name is unique except for the current classroom
            'floor_id' => 'required|exists:floors,id', // Ensure the floor exists in the floors table
        ]);

        // Retrieve the form input data
        $classroomName = $request->input('classroom_name');
        $floorId = $request->input('floor_id');

        // Retrieve the existing classroom by ID
        $classroom = Classroom::find($id);

        if (!$classroom) {
            // If the classroom is not found, return an error message
            return redirect()->route('show_classroom')->with('error', 'Classroom not found.');
        }

        // Update the classroom data
        $classroom->classroom_name = $classroomName;
        $classroom->floor_id = $floorId;
        $classroom->save();

        // Firebase path for the classroom
        $firebasePath = 'classrooms/' . $classroom->id; // Use the classroom ID to avoid name conflicts

        // Update the classroom data in Firebase (without floor_id and archive_status)
        $this->firebaseService->setData($firebasePath, [
            'classroom_name' => $classroomName,
        ]);

        // Redirect back with a success message
        return redirect()->route('show_classroom')->with('success', 'Classroom updated successfully');
    }


    public function removeClassroom($id)
    {
        // Find the floor by id
        $classroom = Classroom::find($id);

        // Set the archive_status to 0
        $classroom->archive_status = 0;
        $classroom->save();

        // Return a success response in JSON format
        return response()->json(['success' => true, 'message' => 'Classroom Removed Successfully']);
    }

   


}
