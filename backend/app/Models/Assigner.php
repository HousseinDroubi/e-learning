<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// import for mongodb
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Assigner extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'instructor_id'
    ];
}
