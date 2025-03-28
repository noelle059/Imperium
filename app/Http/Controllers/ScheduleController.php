<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


use Carbon\Carbon;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ScheduleController extends Controller
{
    use ValidatesRequests;


    public function showSchedule()
    {
        // Fetch classrooms with the related devices (device count), and paginate results
        $classrooms = Classroom::withCount('devices')
            ->where('archive_status', operator: 1)  // Only fetch classrooms where archive_status = 1
            ->paginate(10);

        // Fetch all floors to display in the dropdown
        $users = User::where('archive_status', 1)->get();

        $subjects = Subject::where('archive_status', 1)->get();

        // Fetch schedules with related classrooms, users, and subjects
        $schedules = Schedule::with(['classroom', 'user', 'subject'])  // Assuming 'Schedule' is your model
            ->where('archive_status', true) // Only fetch schedules that are active
            ->paginate(10); // Paginate results



        // Pass classrooms and floors to the view
        return view('admin.schedules', compact('classrooms', 'users', 'subjects', 'schedules'));
    }

    public function getSchedules()
    {
        $schedules = Schedule::with(['classroom.floor', 'user', 'subject'])
            ->where('archive_status', 1)
            ->get();

        $formattedSchedules = $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => "Room: " . $schedule->classroom->classroom_name,
                'start' => date('Y-m-d', strtotime($schedule->schedule_day)) . 'T' . $schedule->start_time,
                'end' => date('Y-m-d', strtotime($schedule->schedule_day)) . 'T' . $schedule->end_time,
                'allDay' => false,
                'extendedProps' => [
                    'classroom_id' => $schedule->classroom->id,
                    'classroom_name' => $schedule->classroom->classroom_name,
                    'floor' => $schedule->classroom->floor->floor_name ?? 'Unknown Floor',
                    'subject' => $schedule->subject->subject_name ?? 'No Subject',
                    'professor' => $schedule->user->name ?? 'Unknown Professor',
                    'registered_time' => Carbon::parse($schedule->start_time)->format('g:i A') . ' to ' . Carbon::parse($schedule->end_time)->format('g:i A'),
                ]
            ];
        });

        return response()->json($formattedSchedules);
    }





    public function addSchedule(Request $request)
    {
        // Validate the incoming request based on form fields
        $this->validate($request, [
            'classroom_id' => 'required|exists:classrooms,id', // Ensure classroom exists
            'user_id' => 'required|exists:users,id', // Ensure professor exists
            'subject_id' => 'required|exists:subjects,id', // Ensure subject exists
            'date' => 'required|date', // Ensure date is in valid format
            'start_time' => 'required|date_format:H:i', // Ensure start time is in valid format
            'end_time' => 'required|date_format:H:i|after:start_time', // Ensure end time is after start time
        ]);

        $classroomId = $request->input('classroom_id');
        $userId = $request->input('user_id');
        $subjectId = $request->input('subject_id');
        $date = $request->input('date');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        $startTime = \Carbon\Carbon::createFromFormat('H:i', $startTime);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $endTime);

        if ($startTime->greaterThanOrEqualTo($endTime)) {
            return redirect()->back()->with('warning', 'Start time must be earlier than end time.');
        }

        // Check if the time slot overlaps with existing schedules
        $overlappingSchedule = Schedule::where('classroom_id', $classroomId)
            ->where('schedule_day', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                // Check if the new start time is within an existing schedule
                $query->whereBetween('start_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                    // Or check if the new end time is within an existing schedule
                    ->orWhereBetween('end_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                    // Or if the new schedule overlaps an existing one completely
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime->format('H:i'))
                            ->where('end_time', '>=', $endTime->format('H:i'));
                    });
            })
            ->first();

        if ($overlappingSchedule) {
            // If the time slot is already occupied, show an alert
            return redirect()->route('show_schedule')->with('error', 'The selected time slot is already occupied by another professor. Please choose another time.');
        }

        // Save the new schedule to the database
        $schedule = new Schedule();
        $schedule->classroom_id = $classroomId;
        $schedule->user_id = $userId;  // Store the professor
        $schedule->subject_id = $subjectId;
        $schedule->schedule_day = $date;
        $schedule->start_time = $startTime->format('H:i');
        $schedule->end_time = $endTime->format('H:i');
        $schedule->save();

        // Redirect back with a success message
        return redirect()->route('show_schedule')->with('success', 'Schedule Added Successfully');
    }




    public function updateSchedule(Request $request, $id)
    {
        Log::info('updateSchedule method called', [
            'schedule_id' => $id,
            'all_request_data' => $request->all()
        ]);

        try {
            $schedule = Schedule::findOrFail($id);
            Log::info('Schedule found', [
                'original_schedule' => $schedule->toArray()
            ]);

            // Explicitly log each field before update
            Log::info('Update attempt', [
                'classroom_id' => $request->input('classroom_id'),
                'user_id' => $request->input('user_id'),
                'subject_id' => $request->input('subject_id'),
                'date' => $request->input('date'),
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time')
            ]);

            $updated = $schedule->update([
                'classroom_id' => $request->input('classroom_id'),
                'user_id' => $request->input('user_id'),
                'subject_id' => $request->input('subject_id'),
                'schedule_day' => $request->input('date'),
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time')
            ]);

            Log::info('Update method result', [
                'updated' => $updated,
                'updated_schedule' => $schedule->toArray()
            ]);

            return redirect()->route('show_schedule')->with('success', 'Schedule Updated Successfully');
        } catch (\Exception $e) {
            Log::error('Update Schedule Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update schedule: ' . $e->getMessage());
        }
    }


    public function removeSchedule($id)
    {
        // Find the floor by id
        $schedule = Schedule::find($id);

        // Set the archive_status to 0
        $schedule->archive_status = 0;
        $schedule->save();

        // Return a success response in JSON format
        return response()->json(['success' => true, 'message' => 'Schedule Removed Successfully']);
    }


    public function printPdf($id, Request $request)
{
    $schedule = Schedule::with(['classroom', 'user', 'subject'])->findOrFail($id);

    // ✅ Get logged-in user's name
    $name = Auth::check() ? Auth::user()->name : 'N/A';

    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $current_date = \Carbon\Carbon::now()->format('F j, Y - g:i A');

    // ✅ Pass the name variable to the Blade template
    $pdf = Pdf::loadView('admin.schedule_pdf', compact('schedule', 'start_date', 'end_date', 'current_date', 'name'));

    return $pdf->download('Schedule_Report.pdf');
}



public function scheduleReport()
{
    $schedules = Schedule::with(['classroom', 'user', 'subject'])->get();
    return view('admin.reports.schedule_report', compact('schedules'));
}



public function printAll(Request $request)
{
    $query = Schedule::with(['classroom', 'user', 'subject']);

    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    if ($start_date) {
        $query->whereDate('schedule_day', '>=', $start_date);
    }
    if ($end_date) {
        $query->whereDate('schedule_day', '<=', $end_date);
    }

    $schedules = $query->get();
    $current_date = \Carbon\Carbon::now()->format('F j, Y - g:i A');

    // ✅ Get logged-in user's name
    $name = Auth::check() ? Auth::user()->name : 'N/A';

    // ✅ Pass the name variable to the Blade template
    $pdf = Pdf::loadView('admin.schedule_pdf_all', compact('schedules', 'start_date', 'end_date', 'current_date', 'name'));

    return $pdf->download('schedule_Report_All.pdf');
}

public function getProfessorSubjects()
{
    $professorId = Auth::id();

    // Get subjects related to the professor via schedules
    $subjects = Schedule::where('user_id', $professorId)
        ->where('archive_status', 1)
        ->with('subject')
        ->get()
        ->pluck('subject')
        ->unique('id');
    return response()->json($subjects);
}

public function checkSchedule(Request $request)
{
    try {
        $classroomId = $request->query('classroom_id');
        $subjectId = $request->query('subject_id');
        $professorId = Auth::id();
        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->format('H:i:s');

        Log::info("🔍 Checking schedule for Classroom: $classroomId, Subject: $subjectId, Professor: $professorId");
        Log::info("📆 Date: $currentDate, 🕒 Time: $currentTime");

        // Retrieve the schedule with all necessary conditions
        $schedule = Schedule::where('classroom_id', $classroomId)
            ->where('subject_id', $subjectId)
            ->where('user_id', $professorId) // logged-in professor or yung nasa database na id lang ang makaka access
            ->where('archive_status', 1)
            ->whereDate('schedule_day', '=', $currentDate)
            ->whereTime('start_time', '<=', $currentTime)
            ->whereTime('end_time', '>=', $currentTime)
            ->first();

        if (!$schedule) {
            Log::warning(" No valid schedule found!");

            // Check if classroom and subject are correct but professor is wrong
            $wrongProfessor = Schedule::where('classroom_id', $classroomId)
                ->where('subject_id', $subjectId)
                ->whereDate('schedule_day', '=', $currentDate)
                ->first();

            if ($wrongProfessor) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not assigned to this subject in this classroom.'
                ]);
            }

            // Check if classroom and professor are correct but subject is wrong
            $wrongSubject = Schedule::where('classroom_id', $classroomId)
                ->where('user_id', $professorId)
                ->whereDate('schedule_day', '=', $currentDate)
                ->first();

            if ($wrongSubject) {
                return response()->json([
                    'error' => true,
                    'message' => 'The selected subject is not assigned to this classroom at this time.'
                ]);
            }

            // Check if classroom and professor are correct but wrong time
            $wrongTime = Schedule::where('classroom_id', $classroomId)
                ->where('user_id', $professorId)
                ->where('subject_id', $subjectId)
                ->where('archive_status', 1)
                ->whereDate('schedule_day', '=', $currentDate)
                ->first();

            if ($wrongTime) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are trying to enter outside of the scheduled time.'
                ]);
            }

            return response()->json([
                'error' => true,
                'message' => 'The selected subject is not scheduled for this classroom at this time.'
            ]);
        }

        Log::info(" Schedule found: " . json_encode($schedule));

        return response()->json([
            'error' => false,
            'message' => 'Schedule is valid.',
            'schedule_id' => $schedule->id
        ]);
    } catch (\Exception $e) {
        Log::error(" Error checking schedule: " . $e->getMessage());
        return response()->json([
            'error' => true,
            'message' => 'An unexpected error occurred. Check logs for details.'
        ]);
    }
}




}
