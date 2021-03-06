<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'slug', 
        'name', 
        'description', 
        'status', 
        'cimage',
        'meta_title', 
        'meta_keyword', 
        'meta_description', 
    ];
}
