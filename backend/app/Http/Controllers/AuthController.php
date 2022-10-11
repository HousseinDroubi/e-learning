<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// import for mongodb
use Jenssegers\Mongodb\Auth\User as Authenticatable;

// Import for jwt
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Authenticatable{

    // Here, the register function can be accessed only by admin, since he's the only one who can
    // create accounts for both students and instructors.
    public function register(Request $request){
        // Make validation for the body request.
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'user_type'=>'required|integer|min:1|max:3',
            'profile_url' => 'required|string',
        ]);
        // If the validation failed, an error response will be returned telling what's wrong.
        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        // In case we have faced a problem while inserting the image, an error will be retruned.
        try{
            // The below syntax will return the path of laravel, so, we have to add the addition
            // path to it in order to save images inside public folder
            $path_image=base_path()."\public\assets\images";
            // current_time is for divinding all users images with different names
            date_default_timezone_set('Asia/Beirut');
            $current_time = date ("Y-m-d H:i:s");
            // Decode the image
            $image_decoded =base64_decode($request->profile_url);
            $path_image=$path_image."\\".strtotime($current_time).".png";
            // Put it inside the above path.
            file_put_contents($path_image, $image_decoded);
            $request->profile_url= $path_image ;
            
        }catch(Exception $e){
            return response()->json([
            'message' => 'Please enter a valid profile'
        ], 201);
        }
        // Create new user
        $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type,
                'profile_url' => $request->profile_url,
            ]);   
        // Return user's data
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(){
        // Login by email and password
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // If the email and password are correct, we have to get this user data in order to 
        // save some of them into the local storage
        $email= $credentials['email'];
        return $this->getUserData($email);
    }

    public function me(){
        return response()->json(auth()->user());
    }

    // Get specific user data
    public function getUserData($email)
    {
        $user = User::where('email',$email)->first();
        return response()->json([
            'message' => 'Done',
            'data'=> $user
        ], 201);
    }


    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    // Not found function is for the middlewares putted for some routes, hence, thoses requests
    // will be redirected to the below function
    public function notFound(){
        return response()->json([
            'message' => 'Access denied'
        ], 400);
    }

    // Get all students.
    public function getStudents(){
        $user = User::where('user_type','3')->get();
        return response()->json([
            'message' => 'Done',
            'data'=> $user
        ], 201);
    }
}
