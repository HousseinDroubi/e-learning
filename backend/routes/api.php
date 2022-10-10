<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

Route::group(["prefix"=> "v0.1"], function(){
   
    Route::group(["middleware" => "auth:api"], function(){
       
        Route::post("/me", [AuthController::class, "me"])->name("get-user-data");
        
   });
   
   Route::get("/get_user", [AuthController::class, "getUserData"])->name("get-user");
   Route::post("/register", [AuthController::class, "register"])->name("register");
   Route::post("/create_course", [CourseController::class, "createCourse"])->name("create-course");
   Route::post("/login", [AuthController::class, "login"])->name("login");
   Route::get("/not_found", [AuthController::class, "notFound"])->name("not-found");
});