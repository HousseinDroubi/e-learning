<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'course_code' => 'required|string|max:100',
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
           'instructor_id'=>$request->instructor_id,
           'course_id'=>$course_id,
        ]);

    return response()->json([
        'message' => 'User successfully registered',
        'user' => $assigner
    ], 201);
    }

    public function getCourses($instructor_id){
        $courses = array();
        $assigners = Assigner::where('instructor_id',$instructor_id)->get();
        foreach($assigners as $assigner){
            array_push($courses,Course::where('_id',$assigner->course_id)->get());
        }

        return response()->json([
            'message' => 'Done',
            'courses' => $courses
        ], 201);
    }
}