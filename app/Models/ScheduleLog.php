<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id',
        'rfid_no',
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'schedule_id', 'id');
    }

}
