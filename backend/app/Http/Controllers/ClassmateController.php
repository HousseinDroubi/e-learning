<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Classmate;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class ClassmateController extends Controller{
    
    public function addClassmate(Request $request){
        
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|string',
            'student_id' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }

        try{
            $classmate = Classmate::create([
           'course_id'=>$request->course_id,
           'student_id'=>$request->student_id,
        ]);
        }catch(Exeption $e){
            return response()->json([
                'message' => 'error',
                'data' => 'duplicate students'
            ], 201);
        }
    return response()->json([
        'message' => 'done',
        'user' => $classmate
    ], 201);
    }
}
