<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Submitter;
use App\Models\Assigner;
use App\Models\Classmate;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class SubmitterController extends Controller
{
    public function submitAssignment(Request $request){
        
        $validator = Validator::make($request->all(), [
            'assignment_id' => 'required|string',
            'student_id' => 'required|string',
            'submit' => 'required|string|min:10',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        
        $submit = Submitter::create([
            'assignment_id' => $request->assignment_id,
            'student_id' => $request->student_id,
            'submit'=>$request->submit,
        ]);

        return response()->json([
            'message' => 'done',
            'user' => $submit
        ], 201);
        }
}
