<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $level)
    {
        if(!Auth::check()){
            return redirect('login');
        }

        $user = Auth::user();

        if($user->role == $level){
            return $next($request);
        }

        return redirect('login')->with('error', "Anda bukan admin");
        // return $next($request);
    }
}
