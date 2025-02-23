<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomHistory extends Model
{
    protected $table = 'room_history';
    protected $fillable = ['room_name', 'professor_name', 'time_in', 'time_out'];

    public function room() {
        return $this->belongsTo(Room::class, 'room_name', 'room_name');
    }
}
