<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['classroom_id', 'device_name', 'state'];
    // Optionally, specify the table name if it's different from the default.
    protected $table = 'devices';

    // Define the inverse relationship with the classroom
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
