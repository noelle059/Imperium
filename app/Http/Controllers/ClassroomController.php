<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\FirebaseService;
use App\Models\Classroom;
use App\Models\Floor;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Schedule;

class ClassroomController extends Controller
{
    use ValidatesRequests;
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }


    public function showClassroom(Request $request)
    {
        $query = Classroom::withCount('devices')->where('archive_status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('classroom_name', 'LIKE', "%{$search}%")
                ->orWhereHas('floor', function ($q) use ($search) {
                    $q->where('floor_name', 'LIKE', "%{$search}%");
                });
        }

        $classrooms = $query->paginate(10)->appends(['search' => $request->input('search')]);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.classroom', compact('classrooms'))->render(),
            ]);
        }

        $floors = Floor::all();
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
        $classroom = Classroom::find($id);

        if (!$classroom) {
            return response()->json(['success' => false, 'message' => 'Classroom not found'], 404);
        }

        $activeSchedules = Schedule::where('classroom_id', $id)
            ->where('archive_status', 1)
            ->exists();

        if ($activeSchedules) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot archive this classroom. They are being used on active schedules.'
            ]);
        }

        $classroom->archive_status = 0;
        $classroom->save();

        return response()->json(['success' => true, 'message' => 'Classroom Removed Successfully']);
    }

}
