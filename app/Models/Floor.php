<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    // Define the table name if it's not the plural of the model
    protected $table = 'floors';

    // Define the fillable fields (this is for mass assignment protection)
    protected $fillable = ['floor_name', 'archive_status'];
}
