<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Subject;


class ScheduleController extends Controller
{
    public function showSchedule()
    {
        // Fetch classrooms with the related devices (device count), and paginate results
        $classrooms = Classroom::withCount('devices') 
            ->where('archive_status', operator: 1)  // Only fetch classrooms where archive_status = 1
            ->paginate(10);

        // Fetch all floors to display in the dropdown
        $users = User::where('archive_status', 1)->get();

        $subjects = Subject::where('archive_status', 1)->get();


        // Pass classrooms and floors to the view
        return view('admin.schedules', compact('classrooms', 'users', 'subjects'));
    }
}
