<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// import for mongodb
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Submitter extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'assignment_id', 'student_id','submit'
    ];
}
