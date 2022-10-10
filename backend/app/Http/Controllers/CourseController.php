<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 
use Auth;
use Validator;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class CourseController extends Controller
{
    public function createCourse(Request $request){
        
        $validator = Validator::make($request->all(), [
            'course_name' => 'required|string|min:4|max:100|unique:users',
            'course_code' => 'required|string|max:100|',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        
        $course = Course::create([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code,
        ]);   

    return response()->json([
        'message' => 'User successfully registered',
        'user' => $course
    ], 201);
    }
}
