<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = "articles";

    protected $fillable = [
        'id',
        'slug', 
        'title', 
        'article_body',
        'description', 
        'coverimage',

        'meta_title', 
        'meta_keyword', 
        'meta_description', 
        'status', 
    ];

}
