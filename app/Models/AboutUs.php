<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    
    protected $table = 'about_us'; // Specify table name
    protected $fillable = [
        'title', 'subtitle', 'abstract', 'article_link', 'image',
        'featured_1', 'featured_2', 'featured_3',
        'modal_title', 'modal_subtitle', 'modal_doi', 'modal_meta', 'modal_abstract', 'modal_article_link'
    ];
    
}

