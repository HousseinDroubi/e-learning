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

class AnnouncementController extends Controller{
    // Create new announcement.
    public function createAnnouncement(Request $request){
        
        // Make validation for the body request.
        $validator = Validator::make($request->all(), [
            'instructor_id' => 'required|string',
            'course_id' => 'required|string',
            'announcement_text' => 'required|string|min:10',
        ]);
        // If the validation failed, an error response will be returned telling what's wrong.
        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }

        // Here, we are creating a new announcement
        $announcement = Announcement::create([
            'instructor_id' => $request->instructor_id,
            'course_id' => $request->course_id,
            'announcement_text'=>$request->announcement_text,
        ]);
        // In case the creation has happened, the announcement's details will be returned
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $announcement
        ], 201);
        }

    // Get all announcements for specific student.
    public function getAnnouncements($student_id){
        $courses_id = Classmate::where("student_id",$student_id)->pluck("course_id");
        // Create an array
        $announcements = array();
        // For each course id, rertrun all it's details
        foreach($courses_id as $course_id){
            array_push($announcements,Announcement::where("course_id",$course_id)->get());
        }
        // Return all announcements.
        return $announcements;
    }

}
