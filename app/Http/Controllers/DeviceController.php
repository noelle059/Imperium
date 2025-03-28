<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Classroom;


use Illuminate\Foundation\Validation\ValidatesRequests;

class DeviceController extends Controller
{
    use ValidatesRequests;
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }



    public function showAddDevices(Request $request)
    {
        $search = $request->input('search'); // Get the search query

        // Get devices where archive_status = 1, filter by search query, and paginate
        $query = Device::where('archive_status', 1);

        if ($search) {
            $query->where('device_name', 'LIKE', "%{$search}%");
        }

        $show_devices = $query->paginate(10);  // Paginate 10 results per page

        // Get all classrooms
        $classrooms = Classroom::all();

        // If it's an AJAX request, return only the table content
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.device', compact('show_devices', 'classrooms'))->render()
            ]);
        }

        // Otherwise, return the full page
        return view('admin.device', compact('show_devices', 'classrooms'));
    }




    public function showEditDevice($id)
    {
        // Find the device by ID
        $device = Device::findOrFail($id);

        // Get all classrooms
        $classrooms = Classroom::all();

        // Return the view with device and classrooms data
        return view('admin.device', compact('device', 'classrooms'));
    }


    public function addDevice(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'classroom_id' => 'required',
            'device_name' => 'required',
        ]);
    
        // Retrieve form input data
        $classroomId = $request->input('classroom_id');
        $deviceName = $request->input('device_name');
    
        // Retrieve the classroom by its ID to get the classroom_name
        $classroom = Classroom::find($classroomId);
    
        // If the classroom doesn't exist, return with an error
        if (!$classroom) {
            return redirect('/admin/show-devices')->with('error', 'Classroom not found.');
        }
    
        // Check if the device already exists in the local database under the same classroom
        $existingDevice = Device::where('classroom_id', $classroomId)
                                ->where('device_name', $deviceName)
                                ->first();
    
        // If the device already exists in the database, prevent insertion and redirect with an error message
        if ($existingDevice) {
            return redirect('/admin/show-devices')->with('error', 'Device with the same name already exists in this classroom.');
        }
    
        // Save the device to the local database
        $device = new Device();
        $device->classroom_id = $classroomId;
        $device->device_name = $deviceName;
        $device->state = false;  // Default state
        $device->archive_status = 1;  // Default archive status
        $device->save();  // Save to the local database
    
        // Firebase path for the device using the newly generated device ID
        $firebasePath = 'classrooms/' . $classroomId . '/devices/' . $device->id;
    
        // Save the device data to Firebase (without archive_status)
        $firebaseData = [
            'device_name' => $deviceName,
            'state' => false,  // Default state is false
        ];
    
        // Use the FirebaseService to set the data in Firebase
        $this->firebaseService->setData($firebasePath, $firebaseData);
    
        // Redirect back with success message
        return redirect('/admin/show-devices')->with('success', 'Device Added Successfully to classroom: ' . $classroom->classroom_name);
    }
    


    /**
     * Archive a device.
     */
    public function remove($id, Request $request)
    {
        $device = Device::findOrFail($id); // Find the subject by

        $device->archive_status = 0; // Set archive_status to 0 (mark as removed)
        $device->save(); // Save changes

        return response()->json(['success' => true]); // Send success response
    }




    public function getDevices($classroomId)
    {
        // Fetch devices from a specific classroom
        $path = 'classrooms/' . $classroomId . '/devices';
        $devices = $this->firebaseService->getData($path);

        return response()->json($devices);
    }



    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'classroom_id' => 'required|numeric',
            'device_name' => 'required|string|max:255',
            'state' => 'required|boolean',  // State should be boolean
        ]);
    
        // Find the device by ID
        $device = Device::find($id);
    
        if (!$device) {
            return redirect()->back()->with('error', 'Device not found.');
        }
    
        // Check if a device with the same name exists in the same classroom (excluding the current device)
        $existingDevice = Device::where('classroom_id', $request->input('classroom_id'))
            ->where('device_name', $request->input('device_name'))
            ->where('id', '!=', $id) // Exclude the current device
            ->first();
    
        if ($existingDevice) {
            return redirect()->back()->with('error', 'A device with this name already exists in the same classroom.');
        }
    
        // Retrieve the classroom by its ID to get the classroom_name
        $classroom = Classroom::find($request->input('classroom_id'));
    
        // If the classroom doesn't exist, return with an error
        if (!$classroom) {
            return redirect()->back()->with('error', 'Classroom not found.');
        }
    
        // Update the device in the local database
        $device->classroom_id = $request->input('classroom_id');
        $device->device_name = $request->input('device_name');
        $device->state = $request->input('state');
        $device->save();  // Save the updated data to the database
    
        // Firebase path for the device
        $classroomId = $request->input('classroom_id');
        $deviceId = $device->id;  // Use the device's ID for the Firebase path
        $deviceName = $request->input('device_name');
        $state = $request->input('state');
    
        // Map state values to true or false
        $firebaseState = ($state == 1) ? true : false;
    
        // Firebase path using the device's unique ID
        $firebasePath = 'classrooms/' . $classroomId . '/devices/' . $deviceId;
        $firebaseData = [
            'device_name' => $deviceName,
            'state' => $firebaseState,  // Update the state to the new value
        ];
    
        // Use the FirebaseService to set the updated data in Firebase
        $this->firebaseService->setData($firebasePath, $firebaseData);
    
        // Redirect with a success message
        return redirect('/admin/show-devices')->with('success', 'Device updated successfully in classroom: ' . $classroom->classroom_name);
    }
    
}
