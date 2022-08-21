<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if(checkAuth()){
            return $next($request);
        }else{
            return redirect('/auth/login');
        }

    }
}
