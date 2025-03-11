<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if table name is plural form of model name)
    protected $table = 'classrooms';

    // Define the fillable fields (these are the fields that can be mass-assigned)
    protected $fillable = [
        'classroom_name',
        'floor_id',
        'archive_status',
    ];

    // Define the relationship with the Floor model (if necessary)
    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }
}
