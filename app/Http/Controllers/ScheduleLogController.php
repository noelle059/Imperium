<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleLog;

class ScheduleLogController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'schedule_id' => 'required|exists:schedules,id',
                'rfid_no' => 'required|string',
                'start_time' => 'nullable|date',
            ]);

            $log = ScheduleLog::create([
                'user_id' => $request->user_id,
                'schedule_id' => $request->schedule_id,
                'rfid_no' => $request->rfid_no,
                'start_time' => now(),
                'end_time' => null,
            ]);

            return response()->json(['success' => true, 'message' => 'Schedule log created successfully', 'log' => $log]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }



    // Get all logs
    public function index()
    {
        $logs = ScheduleLog::with(['user', 'schedule'])->latest()->get();
        return response()->json($logs);
    }

    // Get logs for a specific user
    public function getUserLogs($userId)
    {
        $logs = ScheduleLog::where('user_id', $userId)->with(['schedule'])->latest()->get();
        return response()->json($logs);
    }

    // Update an existing log
    public function update(Request $request, $id)
    {
        $log = ScheduleLog::findOrFail($id);
        $log->update($request->all());

        return response()->json(['message' => 'Schedule log updated successfully', 'log' => $log]);
    }

    // Delete a log entry
    public function destroy($id)
    {
        $log = ScheduleLog::findOrFail($id);
        $log->delete();

        return response()->json(['message' => 'Schedule log deleted successfully']);
    }

    public function getActiveLog(Request $request)
    {
        $activeLog = ScheduleLog::where('user_id', $request->professor_id)
            ->whereHas('schedule', function ($query) use ($request) {
                $query->where('classroom_id', $request->classroom_id);
            })
            ->whereNull('end_time') // Active session check
            ->latest()
            ->first();

        if ($activeLog) {
            return response()->json(['active' => true, 'log_id' => $activeLog->id]);
        } else {
            return response()->json(['active' => false]);
        }
    }

    public function exitClassroom($id)
    {
        $log = ScheduleLog::find($id);
        if (!$log || $log->end_time) {
            return response()->json(['success' => false, 'message' => 'No active session found!']);
        }

        $log->update(['end_time' => now()]);
        return response()->json(['success' => true, 'message' => 'Exit logged successfully']);
    }

}
