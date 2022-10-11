<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Assignment;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class AssignmentController extends Controller
{
    public function createAssignment(Request $request){
        
        $validator = Validator::make($request->all(), [
            'instructor_id' => 'required|string',
            'course_id' => 'required|string',
            'assignment_text' => 'required|string|min:10',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        
        $assignment = Assignment::create([
            'instructor_id' => $request->instructor_id,
            'course_id' => $request->course_id,
            'assignment_text'=>$request->assignment_text,
        ]);

        return response()->json([
            'message' => 'done',
            'user' => $assignment
        ], 201);
        }
}
