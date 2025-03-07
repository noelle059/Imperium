<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterContent extends Model
{
    use HasFactory;

    protected $table = 'footer_contents'; // Specify the table name
    protected $fillable = ['logo', 'description', 'address', 'map_url', 'featured_1', 'featured_2', 'featured_3'];

}
