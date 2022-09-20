<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if(checkProfil(['ADMIN'])){
            return $next($request);
        }else{
            return redirect('/auth/403');
        }

    }
}
