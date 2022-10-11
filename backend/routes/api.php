<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ClassmateController;

Route::group(["prefix"=> "v0.1"], function(){
   
    Route::group(["middleware" => "auth:api"], function(){
       
        Route::post("/me", [AuthController::class, "me"])->name("get-user-data");
        
   });
   
   Route::get("/get_user", [AuthController::class, "getUserData"])->name("get-user");

   Route::post("/login", [AuthController::class, "login"])->name("login");
   Route::get("/not_found", [AuthController::class, "notFound"])->name("not-found");

    //Admin routes
    Route::post("/register", [AuthController::class, "register"])->name("register");
    Route::post("/create_course", [CourseController::class, "createCourse"])->name("create-course");

    //Instructor routes
    Route::get("/get_courses/{instructor_id}", [CourseController::class, "getCourses"])->name("get-courses");
    Route::get("/get_students", [AuthController::class, "getStudents"])->name("get_students");
    Route::post("/create_announcement", [AnnouncementController::class, "createAnnouncement"])->name("create-announcement");
    Route::post("/create_assignemnt", [AssignmentController::class, "createAssignment"])->name("create-assignemnt");
    Route::post("/add_classmate", [ClassmateController::class, "addClassmate"])->name("add-classmate");

});