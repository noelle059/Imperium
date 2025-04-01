<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



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
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'classroom_id' => 'required|exists:classrooms,id',
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'schedule_day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $classroomId = $request->input('classroom_id');
        $userId = $request->input('user_id');
        $subjectId = $request->input('subject_id');
        $dayOfWeek = $request->input('schedule_day');
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->input('start_time'));
        $units = Subject::where('id', $subjectId)->value('units');
        $endTime = $startTime->copy()->addHours($units);

        $lastEndTime = \Carbon\Carbon::createFromFormat('H:i:s', '21:00:00');

        if ($endTime->greaterThan($lastEndTime)) {
            return response()->json([
                'success' => false,
                'errors' => ['The schedule cannot extend beyond 9:00 PM. Please adjust the starting time.']
            ]);
        }

        if ($startTime->greaterThanOrEqualTo($endTime)) {
            return response()->json([
                'success' => false,
                'errors' => ['Start time must be earlier than end time.']
            ]);
        }

            $professorConflict = Schedule::where('schedule_day', $dayOfWeek)
                ->where('user_id', $userId)
                ->where('subject_id', '!=', $subjectId)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where(function ($q) use ($startTime, $endTime) {
                        // Normal case: Both times are within the same day
                        $q->whereTime('start_time', '<', $endTime->format('H:i:s'))
                          ->whereTime('end_time', '>', $startTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTime, $endTime) {
                        // Case when the schedule crosses midnight
                        if ($endTime->format('H:i') < $startTime->format('H:i')) {
                            $q->whereTime('start_time', '>=', $startTime->format('H:i:s'))
                              ->orWhereTime('end_time', '<=', $endTime->format('H:i:s'));
                        }
                    });
                })
                ->exists();

            $professorDifferentRoomConflict = Schedule::where('schedule_day', $dayOfWeek)
                ->where('user_id', $userId)
                ->where('classroom_id', '!=', $classroomId)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where(function ($q) use ($startTime, $endTime) {
                        // Normal case: Both times are within the same day
                        $q->whereTime('start_time', '<', $endTime->format('H:i:s'))
                          ->whereTime('end_time', '>', $startTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTime, $endTime) {
                        // Case when the schedule crosses midnight
                        if ($endTime->format('H:i') < $startTime->format('H:i')) {
                            $q->whereTime('start_time', '>=', $startTime->format('H:i:s'))
                              ->orWhereTime('end_time', '<=', $endTime->format('H:i:s'));
                        }
                    });
                })
                ->exists();

            $classroomConflict = Schedule::where('schedule_day', $dayOfWeek)
                ->where('classroom_id', $classroomId)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where(function ($q) use ($startTime, $endTime) {
                        // Normal case: Both times are within the same day
                        $q->whereTime('start_time', '<', $endTime->format('H:i:s'))
                          ->whereTime('end_time', '>', $startTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTime, $endTime) {
                        // Case when the schedule crosses midnight
                        if ($endTime->format('H:i') < $startTime->format('H:i')) {
                            $q->whereTime('start_time', '>=', $startTime->format('H:i:s'))
                              ->orWhereTime('end_time', '<=', $endTime->format('H:i:s'));
                        }
                    });
                })
                ->exists();

            if ($professorConflict && $classroomConflict) {
                return response()->json([
                    'success' => false,
                    'errors' => ['Both the professor and the classroom are unavailable at this time. Please choose another time slot and classroom']
                ]);
            } elseif ($professorDifferentRoomConflict) {
                return response()->json([
                    'success' => false,
                    'errors' => ['The professor is already scheduled in another classroom at this time. Please choose a different time.']
                ]);
            } elseif ($professorConflict) {
                return response()->json([
                    'success' => false,
                    'errors' => ['The professor already has a schedule on this weekday and time slot. Please choose another time.']
                ]);
            } elseif ($classroomConflict) {
                return response()->json([
                    'success' => false,
                    'errors' => ['The classroom is already occupied at this time. Please choose another classroom or time slot.']
                ]);
            }

        // Save the schedule
        $schedule = new Schedule();
        $schedule->classroom_id = $classroomId;
        $schedule->user_id = $userId;
        $schedule->subject_id = $subjectId;
        $schedule->schedule_day = $dayOfWeek; // Store "Sunday", "Monday", etc.
        $schedule->start_time = $startTime->format('H:i');
        $schedule->end_time = $endTime->format('H:i');
        $schedule->save();

        return response()->json([
            'success' => true,
            'message' => 'Schedule Added Successfully'
        ]);
    }


    public function updateSchedule(Request $request, $id)
    {
        Log::info('updateSchedule method called', [
            'schedule_id' => $id,
            'all_request_data' => $request->all()
        ]);

        try {
            $schedule = Schedule::findOrFail($id);
            Log::info('Schedule found', ['original_schedule' => $schedule->toArray()]);

            // Validate request
            $this->validate($request, [
                'classroom_id' => 'required|exists:classrooms,id',
                'user_id' => 'required|exists:users,id',
                'subject_id' => 'required|exists:subjects,id',
                'schedule_day' => 'required|string',
                'start_time' => 'required|date_format:H:i',
            ]);

            $classroomId = $request->input('classroom_id');
            $userId = $request->input('user_id'); // Professor ID
            $subjectId = $request->input('subject_id');

            // ✅ Use schedule_day directly
            $dayOfWeek = $request->input('schedule_day');

            // Convert start_time to Carbon instance
            $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->input('start_time'));

            // Fetch subject units and calculate end_time
            $units = Subject::where('id', $subjectId)->value('units');
            $endTime = $startTime->copy()->addHours($units);

            Log::info('Start Time:', ['start' => $startTime->format('H:i:s')]);
            Log::info('End Time:', ['end' => $endTime->format('H:i:s')]);

            $lastEndTime = \Carbon\Carbon::createFromFormat('H:i:s', '21:00:00');

            if ($endTime->greaterThan($lastEndTime)) {
                return redirect()->route('show_schedule')->with('error', 'The schedule cannot extend beyond 9:00 PM. Please adjust the starting time.');
            }

            if ($startTime->format('H:i:s') >= $endTime->format('H:i:s')) {
                return redirect()->back()->with('warning', 'Start time must be earlier than end time.');
            }

            $professorConflict = Schedule::where('schedule_day', $dayOfWeek)
                ->where('id', '!=', $id)
                ->where('user_id', $userId)
                ->where('subject_id', '!=', $subjectId)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereTime('start_time', '<', $endTime->format('H:i:s'))
                        ->whereTime('end_time', '>', $startTime->format('H:i:s'));
                })
                ->exists();

            $professorDifferentRoomConflict = Schedule::where('schedule_day', $dayOfWeek)
                ->where('user_id', $userId)
                ->where('classroom_id', '!=', $classroomId) // Different classroom
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereTime('start_time', '<', $endTime->format('H:i:s'))
                          ->whereTime('end_time', '>', $startTime->format('H:i:s'));
                })
                ->exists();


            $classroomConflict = Schedule::where('schedule_day', $dayOfWeek)
                ->where('id', '!=', $id)
                ->where('classroom_id', $classroomId)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereTime('start_time', '<', $endTime->format('H:i:s'))
                        ->whereTime('end_time', '>', $startTime->format('H:i:s'));
                })
                ->exists();

            if ($professorConflict && $classroomConflict) {
                return redirect()->route('show_schedule')->with('error', 'Both the professor and the classroom are unavailable at this time. Please choose another time slot and classroom.');
            } elseif ($professorConflict) {
                return redirect()->route('show_schedule')->with('error', 'The professor already has a schedule on this weekday and time slot. Please choose another time.');
            } elseif ($classroomConflict) {
                return redirect()->route('show_schedule')->with('error', 'The classroom is already occupied at this time. Please choose another classroom or time slot.');
            } elseif ($professorDifferentRoomConflict) {
                return redirect()->route('show_schedule')->with('error', 'The professor is already scheduled in another classroom at this time. Please choose a different time.');
            }

            $existingSchedules = Schedule::where('user_id', $userId)
                ->where('schedule_day', $dayOfWeek)
                ->get();

            Log::info('Existing schedules for this professor on ' . $dayOfWeek, ['schedules' => $existingSchedules->toArray()]);

            $schedule->update([
                'classroom_id' => $classroomId,
                'user_id' => $userId,
                'subject_id' => $subjectId,
                'schedule_day' => $dayOfWeek,
                'start_time' => $startTime->format('H:i'),
                'end_time' => $endTime->format('H:i'),
            ]);

            Log::info('Schedule updated', ['updated_schedule' => $schedule->toArray()]);

            return redirect()->route('show_schedule')->with('success', 'Schedule Updated Successfully');
        } catch (\Exception $e) {
            Log::error('Update Schedule Error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update schedule: ' . $e->getMessage());
        }
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
            $currentDay = Carbon::now()->format('l');
            $currentTime = Carbon::now()->format('H:i:s');

            $schedule = Schedule::where('classroom_id', $classroomId)
                ->where('subject_id', $subjectId)
                ->where('user_id', $professorId)
                ->where('archive_status', 1)
                ->where('schedule_day', '=', $currentDay)
                ->whereTime('start_time', '<=', $currentTime)
                ->whereTime('end_time', '>=', $currentTime)
                ->first();

            if (!$schedule) {
                Log::warning("❌ No valid schedule found!");

                // Classroom and subject tama pero wrong professor
                $wrongProfessor = Schedule::where('classroom_id', $classroomId)
                    ->where('subject_id', $subjectId)
                    ->where('schedule_day', '=', $currentDay)
                    ->first();

                if ($wrongProfessor) {
                    return response()->json([
                        'error' => true,
                        'message' => 'You are not assigned to this subject in this classroom.'
                    ]);
                }

                // Classroom and professor tama pero wrong subject
                $wrongSubject = Schedule::where('classroom_id', $classroomId)
                    ->where('user_id', $professorId)
                    ->where('schedule_day', '=', $currentDay)
                    ->first();

                if ($wrongSubject) {
                    return response()->json([
                        'error' => true,
                        'message' => 'The selected subject is not assigned to this classroom at this time.'
                    ]);
                }

                // Classroom and professor tama pero wrong time
                $wrongTime = Schedule::where('classroom_id', $classroomId)
                    ->where('user_id', $professorId)
                    ->where('subject_id', $subjectId)
                    ->where('archive_status', 1)
                    ->where('schedule_day', '=', $currentDay)
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

            Log::info("✅ Schedule found: " . json_encode($schedule));

            return response()->json([
                'error' => false,
                'message' => 'Schedule is valid.',
                'schedule_id' => $schedule->id
            ]);
        } catch (\Exception $e) {
            Log::error("❌ Error checking schedule: " . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'An unexpected error occurred. Check logs for details.'
            ]);
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


    





}
