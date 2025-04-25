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


// SceduleController.php

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

            $validator = Validator::make($request->all(), [
                'subject_id' => 'required|exists:subjects,id',
                // Include other validations as needed
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()->all()
                ], 422);
            }

            $classroomId = $request->query('classroom_id');
            $scheduleDay = $request->query('schedule_day');
            $startTime = $request->query('start_time');
            $professorId = $request->query('professor_id');
            $subjectId = $request->query('subject_id');
            $scheduleId = $request->query('schedule_id');

            $startTimeCarbon = \Carbon\Carbon::createFromFormat('H:i', $startTime);

            // Get subject units
            $units = Subject::where('id', $subjectId)->value('units') ?? 1;
            $endTime = $startTimeCarbon->copy()->addHours($units);

            // For debugging
            Log::info('Checking schedule conflicts:', [
                'start_time' => $startTimeCarbon->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'day' => $scheduleDay,
                'professor' => $professorId,
                'classroom' => $classroomId,
                'subject' => $subjectId
            ]);

            $response = [
                'error' => false,
                'message' => []
            ];

            // Time validation: Check if end time exceeds 9 PM
            $lastEndTime = \Carbon\Carbon::createFromFormat('H:i:s', '21:00:00');
            if ($endTime->greaterThan($lastEndTime)) {
                $response['error'] = true;
                $response['message']['time'] = 'The schedule cannot extend beyond 9:00 PM. Please adjust the starting time.';
            }

            // Time validation: Ensure start time is before end time
            if ($startTimeCarbon->greaterThanOrEqualTo($endTime)) {
                $response['error'] = true;
                $response['message']['time'] = 'Start time must be earlier than end time.';
            }

            $professorConflictQuery = Schedule::where('schedule_day', $scheduleDay)
                ->where('user_id', $professorId)
                ->where('subject_id', '!=', $subjectId)
                ->where(function ($query) use ($startTimeCarbon, $endTime) {
                    $query->where(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '>', $startTimeCarbon->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<', $endTime->format('H:i:s'))
                          ->whereTime('end_time', '>=', $endTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '>=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '<=', $endTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '>=', $endTime->format('H:i:s'));
                    });
                });

            if ($scheduleId) {
                $professorConflictQuery->where('id', '!=', $scheduleId);
            }

            $professorConflict = $professorConflictQuery->exists();

            if ($professorConflict) {
                $response['error'] = true;
                $response['message']['professor'] = 'The professor already has a schedule with a different subject at this time.';
            }

            // Apply the same improved overlap detection to the other checks

            // PROFESSOR DIFFERENT ROOM CONFLICT
            $professorDifferentRoomQuery = Schedule::where('schedule_day', $scheduleDay)
                ->where('user_id', $professorId)
                ->where('classroom_id', '!=', $classroomId)
                ->where(function ($query) use ($startTimeCarbon, $endTime) {
                    $query->where(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '>', $startTimeCarbon->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<', $endTime->format('H:i:s'))
                          ->whereTime('end_time', '>=', $endTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '>=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '<=', $endTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '>=', $endTime->format('H:i:s'));
                    });
                });

            if ($scheduleId) {
                $professorDifferentRoomQuery->where('id', '!=', $scheduleId);
            }

            $professorDifferentRoomConflict = $professorDifferentRoomQuery->exists();

            if ($professorDifferentRoomConflict) {
                $response['error'] = true;
                $response['message']['professor_room'] = 'The professor is already scheduled in another classroom at this time.';
            }

            // CLASSROOM CONFLICT
            $classroomConflictQuery = Schedule::where('schedule_day', $scheduleDay)
                ->where('classroom_id', $classroomId)
                ->where(function ($query) use ($startTimeCarbon, $endTime) {
                    $query->where(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '>', $startTimeCarbon->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<', $endTime->format('H:i:s'))
                          ->whereTime('end_time', '>=', $endTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '>=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '<=', $endTime->format('H:i:s'));
                    })->orWhere(function ($q) use ($startTimeCarbon, $endTime) {
                        $q->whereTime('start_time', '<=', $startTimeCarbon->format('H:i:s'))
                          ->whereTime('end_time', '>=', $endTime->format('H:i:s'));
                    });
                });

            if ($scheduleId) {
                $classroomConflictQuery->where('id', '!=', $scheduleId);
            }

            $classroomConflict = $classroomConflictQuery->exists();

            if ($classroomConflict) {
                $response['error'] = true;
                $response['message']['classroom'] = 'The classroom is already occupied at this time.';
            }


            $existingSchedules = Schedule::where('schedule_day', $scheduleDay)
            ->where(function ($query) use ($professorId, $classroomId) {
                $query->where('user_id', $professorId)
                    ->orWhere('classroom_id', $classroomId);
            })
            ->where('id', '!=', $scheduleId)
            ->where('archive_status', 1)
            ->get();

            Log::info('Existing schedules that might conflict:', $existingSchedules->toArray());

            foreach ($existingSchedules as $existing) {
            $existingStart = \Carbon\Carbon::createFromFormat('H:i:s', $existing->start_time);
            $existingEnd = \Carbon\Carbon::createFromFormat('H:i:s', $existing->end_time);

            $hasOverlap = (
                ($startTimeCarbon >= $existingStart && $startTimeCarbon < $existingEnd) ||
                ($endTime > $existingStart && $endTime <= $existingEnd) ||
                ($startTimeCarbon <= $existingStart && $endTime >= $existingEnd) ||
                ($startTimeCarbon >= $existingStart && $endTime <= $existingEnd)
            );

            if ($hasOverlap && !$response['error']) {
                Log::warning('Direct comparison found overlap but SQL did not!');

                if ($existing->user_id == $professorId && $existing->classroom_id != $classroomId) {
                    $response['error'] = true;
                    $response['message']['professor_room'] = 'The professor is already scheduled in another classroom at this time (detected by direct comparison).';
                } else if ($existing->user_id == $professorId) {
                    $response['error'] = true;
                    $response['message']['professor'] = 'The professor already has a schedule at this time (detected by direct comparison).';
                } else if ($existing->classroom_id == $classroomId) {
                    $response['error'] = true;
                    $response['message']['classroom'] = 'The classroom is already occupied at this time (detected by direct comparison).';
                }
            }
            }

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Schedule check error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => true,
                'message' => ['An unexpected error occurred: ' . $e->getMessage()]
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

    public function validateSchedule(Request $request)
    {
        // Get the parameters from the request
        $userId = $request->input('user_id');  // Logged-in user's ID
        $classroomId = $request->input('classroom_id');  // Classroom ID (CL1 = 32)
        $currentTime = $request->input('current_time');  // Current time in ISO format

        // Convert current time to Carbon instance, but extract only the time part (HH:MM:SS)
        $currentTime = Carbon::parse($currentTime)->timezone('Asia/Manila')->format('H:i:s'); // Convert to HH:MM:SS in Manila timezone

        // Fetch the schedule for the logged-in user in the given classroom (CL1)
        $schedule = Schedule::where('user_id', $userId)
                            ->where('classroom_id', $classroomId)
                            ->first();

        // Check if a valid schedule exists
        if ($schedule) {
            $startTime = Carbon::parse($schedule->start_time)->timezone('Asia/Manila')->format('H:i:s');
            $endTime = Carbon::parse($schedule->end_time)->timezone('Asia/Manila')->format('H:i:s');

            // Compare the current time with the schedule's start and end times
            if ($currentTime >= $startTime && $currentTime <= $endTime) {
                return response()->json([
                    'validSchedule' => true,
                    'scheduleId' => $schedule->id,
                ]);
            } else {
                return response()->json(['validSchedule' => false]);
            }
        } else {
            // If no schedule found for this professor in this classroom
            return response()->json(['validSchedule' => false]);
        }
    }


}
