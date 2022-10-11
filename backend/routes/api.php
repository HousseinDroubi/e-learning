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

    // Login for all users
   Route::post("/login", [AuthController::class, "login"])->name("login");

    // The below route is used for requests asked by those who didn't have the permission for it.    
   Route::get("/not_found", [AuthController::class, "notFound"])->name("not-found");

    //Admin routes
    Route::group(["middleware" => "auth.admin"], function(){ 
        // Register route is about creating either student account or instructor account
        Route::post("/register", [AuthController::class, "register"])->name("register");
        // Create course and assign it to a specific instructor
        Route::post("/create_course", [CourseController::class, "createCourse"])->name("create-course");
   });

    //Instructor routes
    // Get all courses assigned to this instructor
    Route::get("/get_courses/{instructor_id}", [CourseController::class, "getCourses"])->name("get-courses");
    // Get students route is for add students for a specific course 'later on'.
    Route::get("/get_students", [AuthController::class, "getStudents"])->name("get_students");
        
    // These routes need middleware in order to not be asked by an admin or student
    Route::group(["middleware" => "auth.instructor"], function(){
        Route::post("/create_announcement", [AnnouncementController::class, "createAnnouncement"])->name("create-announcement");
        Route::post("/create_assignemnt", [AssignmentController::class, "createAssignment"])->name("create-assignemnt");
        // Add students for a specific course after asking for get_students routes.
        Route::post("/add_classmate", [ClassmateController::class, "addClassmate"])->name("add-classmate");    
    });

    //Student routes
    Route::get("/my_courses/{student_id}", [CourseController::class, "getStudentCourses"])->name("my-courses");
    // course enroller is to get all classmates for a specific course
    Route::get("/course_enrolled/{course_id}", [CourseController::class, "getCourseEnrolled"])->name("course-enrolled");
    // Get all announcement for specific student
    Route::get("/my_announcements/{student_id}", [AnnouncementController::class, "getAnnouncements"])->name("my-announcement");
    // Get all assignments for specific student
    Route::get("/my_assignments/{student_id}", [AssignmentController::class, "getAssignments"])->name("my-assignment");

    // The below route need middleware in order to not be asked by an admin or instructor
    Route::group(["middleware" => "auth.student"], function(){
        // submit an assignment from a student
        Route::post("/submit_assignment", [SubmitterController::class, "submitAssignment"])->name("submit-assignment");
    });
});