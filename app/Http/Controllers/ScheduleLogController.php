<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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


    public function printPdf($id, Request $request)
    {
        $log = ScheduleLog::with(['schedule.classroom', 'user', 'schedule.subject'])
            ->findOrFail($id);
    
        $name = Auth::check() ? Auth::user()->name : 'N/A';
        $current_date = now()->format('F j, Y - g:i A');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        // Ensure RFID is included
        $rfid = $log->rfid_no ?? 'N/A';  // Change from $log->rfid to $log->rfid_no

    
        $pdf = Pdf::loadView('admin.schedule_log_pdf', compact('log', 'start_date', 'end_date', 'current_date', 'name', 'rfid'))
        ->setPaper('a4', 'landscape');

        return $pdf->download('Schedule_Log_Report.pdf');
    }
    

    public function scheduleLogReport()
{
    $logs = ScheduleLog::with(['schedule.classroom', 'user', 'schedule.subject'])->latest()->get();
    return view('admin.reports.schedule_report', compact('logs'));
}

public function printAll(Request $request)
{
    $query = ScheduleLog::with(['schedule.classroom', 'user', 'schedule.subject']);

    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $room_name = $request->input('room_name'); // Get room name from request

    if ($start_date) {
        $query->whereDate('created_at', '>=', $start_date);
    }
    if ($end_date) {
        $query->whereDate('created_at', '<=', $end_date);
    }
    if ($room_name) {
        $query->whereHas('schedule.classroom', function ($q) use ($room_name) {
            $q->where('classroom_name', 'LIKE', "%$room_name%");
        });
    }

    $logs = $query->get();
    $current_date = now()->format('F j, Y - g:i A');
    $name = Auth::check() ? Auth::user()->name : 'N/A';

    // Generate PDF
    $pdf = Pdf::loadView('admin.schedule_log_pdf_all', compact('logs', 'start_date', 'end_date', 'room_name', 'current_date', 'name'))
              ->setPaper('a4', 'landscape');

    return $pdf->download('Schedule_Log_Report_All.pdf');
}


    //print-view table for logs
    public function viewLogs()
    {
        $logs = ScheduleLog::with(['user', 'schedule'])->latest()->get();
        return view('admin.reports.schedule_report', compact('logs'));
    }
    

    public function showLogs()
    {
        $logs = ScheduleLog::with(['schedule.classroom', 'schedule.subject', 'user'])->latest()->get();
        
        // Update the view path to the new location
        return view('admin.reports.schedule_report', compact('logs')); // Updated path
    }



    

}
