<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'professor_name',
        'status',
        'time_in',
        'controller',
    ];

    public function history() {
        return $this->hasMany(RoomHistory::class, 'room_name', 'room_name');
    }
}
