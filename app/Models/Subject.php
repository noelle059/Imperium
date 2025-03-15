<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'subject_id');
    }


}
