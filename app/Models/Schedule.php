<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $fillable = [
        'classroom_id', 'user_id', 'subject_id', 'start_time', 'end_time', 'schedule_day', 'archive_status'
    ];

    // Relationship with the Classroom model
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with the Subject model
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function scheduleLogs()
    {
        return $this->hasMany(ScheduleLog::class);
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
