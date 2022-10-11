<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// import for mongodb
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Announcement extends Eloquent
{
    use HasFactory;
    protected $fillable = [
        'instructor_id', 'course_id','announcement_text'
    ];
}
