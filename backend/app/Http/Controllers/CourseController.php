<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 
use Auth;
use Validator;
use App\Models\Course;
use App\Models\Assigner;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class CourseController extends Controller
{
    public function createCourse(Request $request){
        
        $validator = Validator::make($request->all(), [
            'course_name' => 'required|string|min:4|max:100|unique:users',
            'course_code' => 'required|string|max:100|',
            'instructor_id' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        
        $course = Course::create([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code,
        ]);   
        $course_id = $course->id;

        $assigner = Assigner::create([
           'instrucor_id'=>$request->instrucor_id,
           'course_id'=>$course_id,
        ]);

    return response()->json([
        'message' => 'User successfully registered',
        'user' => $assigner
    ], 201);
    }
}
