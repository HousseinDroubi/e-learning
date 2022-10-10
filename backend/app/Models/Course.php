<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// import for mongodb
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Course extends Model
{
    use HasFactory;
    
    protected $connection = 'mongodb';
    protected $collection = 'courses';
    
    protected $fillable = [
        'course_code', 'course_name'
    ];
}
