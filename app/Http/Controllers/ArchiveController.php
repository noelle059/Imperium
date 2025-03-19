<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Floor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Device;

class ArchiveController extends Controller
{

    public function showArchiveAccount()
    {
        // Use query builder to paginate before fetching the data
        $archiveUsers = User::where('archive_status', 0)  // Filter by archive_status = 0
            ->paginate(10);  // Paginate the results

        // Use query builder to paginate before fetching the data
        $archiveFloors = Floor::where('archive_status', 0)  // Filter by archive_status = 0
            ->paginate(10);  // Paginate the results


        // Pass archiveUsers to the view
        return view('admin.archive.account', compact('archiveUsers', 'archiveFloors'));
    }

    public function retrieveAccount($id)
    {
        // Find the floor by id
        $user = User::find($id);

        // Set the archive_status to 0
        $user->archive_status = 1;
        $user->save();

        // Return a success response in JSON format
        return response()->json(['success' => true, 'message' => 'Schedule Retrieved Successfully']);
    }


    public function showArchiveFloor()
    {

        // Use query builder to paginate before fetching the data
        $archiveFloors = Floor::where('archive_status', 0)  // Filter by archive_status = 0
            ->paginate(10);  // Paginate the results


        // Pass archiveUsers to the view
        return view('admin.archive.floor', compact('archiveFloors'));
    }


    public function retrieveFloor($id)
    {
        // Find the floor by id
        $floor = Floor::find($id);

        // Set the archive_status to 0
        $floor->archive_status = 1;
        $floor->save();

        // Return a success response in JSON format
        return response()->json(['success' => true, 'message' => 'Floor Building Retrieved Successfully']);
    }



    public function showArchiveClassroom()
    {

        // Fetch classrooms with the related devices (device count), and paginate results
        $archiveClassrooms = Classroom::withCount('devices')  // Count the devices for each classroom
            ->where('archive_status', 0)  // Only fetch classrooms where archive_status = 1
            ->paginate(10);

        // Fetch all floors to display in the dropdown
        $floors = Floor::all();

        // Pass archiveUsers to the view
        return view('admin.archive.classroom', compact('archiveClassrooms', 'floors'));
    }



    public function retrieveClassroom($id)
    {
        // Find the floor by id
        $classroom = Classroom::find($id);

        // Set the archive_status to 0
        $classroom->archive_status = 1;
        $classroom->save();

        // Return a success response in JSON format
        return response()->json(['success' => true, 'message' => 'Classroom Retrieved Successfully']);
    }



    public function showArchiveDevice()
    {

        // Use query builder to paginate before fetching the data
        $archiveDevices = Device::where('archive_status', 0)  // Filter by archive_status = 0
            ->paginate(10);  // Paginate the results

        // Get all classrooms
        $classrooms = Classroom::all();

        // Pass archiveUsers to the view
        return view('admin.archive.device', compact('archiveDevices', 'classrooms'));
    }


    public function retrieveDevice($id)
    {
        // Find the floor by id
        $device = Device::find($id);

        // Set the archive_status to 0
        $device->archive_status = 1;
        $device->save();

        // Return a success response in JSON format
        return response()->json(['success' => true, 'message' => 'Device Retrieved Successfully']);
    }
}
