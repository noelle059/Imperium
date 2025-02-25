<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ Correct namespace

class Notification extends Model
{
    use HasFactory, SoftDeletes; // ✅ Use SoftDeletes properly

    protected $dates = ['deleted_at']; // Timestamp for soft deletes

    protected $fillable = ['user_id', 'message', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
