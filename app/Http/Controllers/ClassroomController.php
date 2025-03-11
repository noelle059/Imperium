<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\FirebaseService;
use App\Models\Classroom;
use App\Models\Floor;

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
        // Fetch classrooms with archive_status = 1, paginate results
        $classrooms = Classroom::where('archive_status', 1)->paginate(10);
        // Fetch all floors to display in the dropdown
        $floors = Floor::all();

        // Pass classrooms and floors to the view
        return view('admin.classroom', compact('classrooms', 'floors'));
    }




    public function addClassroom(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'classroom_name' => 'required',
            'floor_id' => 'required',
        ]);

        // Retrieve the form input data
        $classroomName = $request->input('classroom_name');
        $floorId = $request->input('floor_id');

        // Check if the classroom already exists in the local database
        $existingClassroom = Classroom::where('classroom_name', $classroomName)->first();

        if ($existingClassroom) {
            // If the classroom already exists in the local database, return an error message
            return redirect()->route('show_classroom')->with('error', 'Classroom with the same name already exists in the database.');
        }

        // Firebase path to check for the existing classroom
        $firebasePath = 'classrooms/' . $classroomName;



        // Check if the classroom already exists in Firebase
        $existingClassroomInFirebase = $this->firebaseService->getData($firebasePath);

        if ($existingClassroomInFirebase) {
            // If the classroom already exists in Firebase, return an error message
            return redirect()->route('show_classroom')->with('error', 'Classroom with the same name already exists in Firebase.');
        }

        // Save the classroom to the local database
        $classroom = new Classroom();
        $classroom->classroom_name = $classroomName;
        $classroom->floor_id = $floorId;
        $classroom->archive_status = 1;  // Default archive status
        $classroom->save();



        // Save the data to Firebase
        $this->firebaseService->setData($firebasePath, '/devices/');

        // Redirect back with a success message
        return redirect()->route('show_classroom')->with('success', 'Classroom Added Successfully');
    }
}
