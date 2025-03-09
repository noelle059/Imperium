<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use App\Models\Device;


use Illuminate\Foundation\Validation\ValidatesRequests;

class DeviceController extends Controller
{
    use ValidatesRequests;
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }



    public function showAddDevices()
    {
        // Get professors (admin users) where archive_status = 1 and paginate 10
        $show_devices = Device::where('archive_status', 1)  // Only those with archive_status = 1
            ->paginate(10);  // Paginate 10 results per page

        // Return the view with the professors data
        return view('admin.device', compact('show_devices'));
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

        // Check if the device already exists in Firebase
        $path = 'classrooms/' . $classroomId . '/devices/' . $deviceName;
        $existingDevice = $this->firebaseService->getData($path);

        // If the device already exists in Firebase, prevent insertion and redirect with an error message
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

        // Prepare the data for Firebase (state is always false as you set it)
        $firebaseData = [
            'state' => false,  // Default state is false
        ];

        // Use the FirebaseService to set the data in Firebase
        $this->firebaseService->setData($path, $firebaseData);

        // Redirect back with success message
        return redirect('/admin/show-devices')->with('success', 'Device Added Successfully');
    }


    /**
     * Archive a device.
     */
    public function remove($id, Request $request)
    {
        $device = Device::findOrFail($id); // Find the subject by ID

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



    // Update device method
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

        // Update the device in the local database
        $device->classroom_id = $request->input('classroom_id');
        $device->device_name = $request->input('device_name');
        $device->state = $request->input('state');
        $device->save();  // Save the updated data to the database

        // Update the device in Firebase
        $classroomId = $request->input('classroom_id');
        $deviceName = $request->input('device_name');
        $state = $request->input('state');

        // Map state values to true or false
        $firebaseState = ($state == 1) ? true : false;

        $path = 'classrooms/' . $classroomId . '/devices/' . $deviceName;
        $firebaseData = [
            'state' => $firebaseState,
        ];

        // Use the FirebaseService to set the updated data in Firebase
        $this->firebaseService->setData($path, $firebaseData);

        // Redirect with a success message
        return redirect('/admin/show-devices')->with('success', 'Device updated successfully.');
    }
}
