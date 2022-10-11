<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Announcement;
use App\Models\Assigner;
use App\Models\Classmate;
use App\Http\Controllers\Controller;
use Jessengesr\Mongodb\Eloquent\Model;

class AnnouncementController extends Controller
{
    public function createAnnouncement(Request $request){
        
        $validator = Validator::make($request->all(), [
            'instructor_id' => 'required|string',
            'course_id' => 'required|string',
            'announcement_text' => 'required|string|min:10',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        
        $announcement = Announcement::create([
            'instructor_id' => $request->instructor_id,
            'course_id' => $request->course_id,
            'announcement_text'=>$request->announcement_text,
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $announcement
        ], 201);
        }

        public function getAnnouncements($student_id){
            $courses_id = Classmate::where("student_id",$student_id)->pluck("course_id");
            // return $courses_id;
            $announcements = array();
            foreach($courses_id as $course_id){
                array_push($announcements,Announcement::where("course_id",$course_id)->get());
            }
            return $announcements;
        }

}
