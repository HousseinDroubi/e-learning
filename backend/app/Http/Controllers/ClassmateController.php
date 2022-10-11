<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Classmate;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class ClassmateController extends Controller{
    
    // addClassmate is to add the student for specific course 
    public function addClassmate(Request $request){
        
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|string',
            'student_id' => 'required|string',
        ]);
        // If the validation failed, an error response will be returned telling what's wrong.
        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }

        // In case we're facing errors to enter the student to a specifc course, so that means
        // an instructor is trying to make duplicates for these two columns
        try{
            $classmate = Classmate::create([
           'course_id'=>$request->course_id,
           'student_id'=>$request->student_id,
        ]);
        //Return duplicate error
        }catch(Exception $e){
            return response()->json([
                'message' => 'error',
                'data' => 'duplicate students'
            ], 201);
        }
        // In case the inserting has happened, we have to add message contains done.
        return response()->json([
            'message' => 'done',
            'user' => $classmate
        ], 201);
        }
}
