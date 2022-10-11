<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Jessengesr\Mongodb\Eloquent\Model;
use App\Models\User;

class AuthInstructor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){

        // Here we are giving access for the admin requests only when the user type is '2'
        $user_type =User::where('_id', $request->id)->pluck('user_type')->first();

        if($user_type=="2"){
            return $next($request);
        }
        return redirect()->route('not-found');
            
    }
}
