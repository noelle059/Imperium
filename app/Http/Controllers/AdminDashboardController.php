<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\Subject;
use App\Models\User;
use App\Models\Classroom;


class AdminDashboardController extends Controller
{
    // Pass and display the request data in the admin dashboard
    public function showAdminDashboard()
    {
        // Fetch users with archive_status = 1
        $users = User::where('archive_status', 1)->get();

        // Fetch subjects with archive_status = 1
        $subjects = Subject::where('archive_status', 1)->get();

        // Fetch devices with state = 1 and archive_status = 1
        $devices = Device::where('archive_status', 1)->where('state', 1)->get();

        // Fetch classrooms with archive_status = 1
        $classrooms = Classroom::where('archive_status', 1)->get();

        // Count the number of users with archive_status = 1
        $userCount = $users->count();

        // Count the number of subjects with archive_status = 1
        $subjectCount = $subjects->count();

        // Count the number of devices with state = 1 and archive_status = 1
        $deviceCount = $devices->count();


        $classroomCount = $classrooms->count();

        // Pass data to the view
        return view('admin.dashboard', compact('users', 'subjects', 'devices', 'classrooms', 'userCount', 'subjectCount', 'deviceCount', 'classroomCount'));
    }
}
