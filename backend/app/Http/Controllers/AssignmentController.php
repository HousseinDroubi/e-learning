<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Assignment;
use App\Models\Classmate;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class AssignmentController extends Controller{

    // Create new assignment.
    public function createAssignment(Request $request){
        
        // Make validation for the body request.
        $validator = Validator::make($request->all(), [
            'instructor_id' => 'required|string',
            'course_id' => 'required|string',
            'assignment_text' => 'required|string|min:10',
        ]);
        // If the validation failed, an error response will be returned telling what's wrong.
        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        
        // Here, we are creating a new assignment
        $assignment = Assignment::create([
            'instructor_id' => $request->instructor_id,
            'course_id' => $request->course_id,
            'assignment_text'=>$request->assignment_text,
        ]);

        // In case the creation has happened, the assignment's details will be returned
        return response()->json([
            'message' => 'done',
            'user' => $assignment
        ], 201);
        }

        // Get all assignments for specific student.
        public function getAssignments($student_id){
            $courses_id = Classmate::where("student_id",$student_id)->pluck("course_id");
            // Create an array
            $assignments = array();
            // For each course id, rertrun all it's details
            foreach($courses_id as $course_id){
                array_push($assignments,Assignment::where("course_id",$course_id)->get());
            }
            // Return all assignments.
            return $assignments;
        }
}
