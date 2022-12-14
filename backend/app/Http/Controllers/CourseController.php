<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Course;
use App\Models\Assigner;
use App\Models\Classmate;
use App\Models\User;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class CourseController extends Controller{
    
    //Create course function
    public function createCourse(Request $request){
        //Make our needed validations
        $validator = Validator::make($request->all(), [
            'course_name' => 'required|string|min:4|max:100|unique:users',
            'course_code' => 'required|string|max:100',
            'instructor_id' => 'required|string',
        ]);
        // If the validation failed, an error response will be returned telling what's wrong.
        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        // Create course if the validation is done
        $course = Course::create([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code,
        ]);   
        // Here, we are getting the id to assign this course to a specific instructor
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
    // Get all courses function
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

    // Get courses for specific students
    public function getStudentCourses($student_id){
        $courses_id = Classmate::where("student_id",$student_id)->pluck("course_id");
        $my_courses = array();
        foreach ($courses_id as $course_id){
            array_push($my_courses,Course::where("_id",$course_id)->get());
        } 
        return $my_courses;
    }

    // getCourseEnrolled is to get the students for a specific course
    public function getCourseEnrolled($course_id){
        $students_id = Classmate::where("course_id",$course_id)->pluck("student_id");
        $students_enrolled= array();
        foreach ($students_id as $student_id){
            array_push($students_enrolled,User::where("_id",$student_id)->get());
        } 
        return $students_enrolled;
    }
}