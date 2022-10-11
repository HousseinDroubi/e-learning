<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// import for mongodb
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Classmate extends Eloquent
{
    use HasFactory;
    
    protected $fillable = [
        'course_id', 'student_id'
    ];
}
