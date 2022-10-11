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

class AuthController extends Authenticatable
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'user_type'=>'required|integer|min:1|max:3',
            'profile_url' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }

        try{
                $path_image=base_path()."\public\assets\images";
                date_default_timezone_set('Asia/Beirut');
                $current_time = date ("Y-m-d H:i:s");
                $image_decoded =base64_decode($request->profile_url);
                $path_image=$path_image."\\".strtotime($current_time).".png";
                file_put_contents($path_image, $image_decoded);
                $request->profile_url= $path_image ;
            
        }catch(Exception $e){
            return response()->json([
            'message' => 'Please enter a valid profile'
        ], 201);
        }

        $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type,
                'profile_url' => $request->profile_url,
            ]);   

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $email= $credentials['email'];
        return $this->getUserData($email);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
    public function getUserData($email)
    {
        $user = User::where('email',$email)->first();
        return response()->json([
            'message' => 'Done',
            'data'=> $user
        ], 201);
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function notFound(){
        return response()->json([
            'message' => 'Access denied'
        ], 400);
    }
}
