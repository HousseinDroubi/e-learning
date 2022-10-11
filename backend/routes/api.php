<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ClassmateController;
use App\Http\Controllers\SubmitterController;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthInstructor;

// Version 0.1
Route::group(["prefix"=> "v0.1"], function(){

   Route::post("/login", [AuthController::class, "login"])->name("login");
   Route::get("/not_found", [AuthController::class, "notFound"])->name("not-found");

    //Admin routes
    Route::group(["middleware" => "auth.admin"], function(){ 
        Route::post("/register", [AuthController::class, "register"])->name("register");
        Route::post("/create_course", [CourseController::class, "createCourse"])->name("create-course");
   });

    //Instructor routes
    Route::get("/get_courses/{instructor_id}", [CourseController::class, "getCourses"])->name("get-courses");
    Route::get("/get_students", [AuthController::class, "getStudents"])->name("get_students");
        
    Route::group(["middleware" => "auth.instructor"], function(){
        Route::post("/create_announcement", [AnnouncementController::class, "createAnnouncement"])->name("create-announcement");
        Route::post("/create_assignemnt", [AssignmentController::class, "createAssignment"])->name("create-assignemnt");
        Route::post("/add_classmate", [ClassmateController::class, "addClassmate"])->name("add-classmate");    
    });

    //Student routes
    Route::get("/my_courses/{student_id}", [CourseController::class, "getStudentCourses"])->name("my-courses");

    Route::get("/course_enrolled/{course_id}", [CourseController::class, "getCourseEnrolled"])->name("course-enrolled");

    Route::get("/my_announcements/{student_id}", [AnnouncementController::class, "getAnnouncements"])->name("my-announcement");

    Route::get("/my_assignments/{student_id}", [AssignmentController::class, "getAssignments"])->name("my-assignment");

    Route::group(["middleware" => "auth.student"], function(){
        Route::post("/submit_assignment", [SubmitterController::class, "submitAssignment"])->name("submit-assignment");
    });
});