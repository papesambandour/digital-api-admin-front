<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SupportMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if(checkProfil(['ADMIN','SUPPORT'])){
            return $next($request);
        }else{
            return redirect('/auth/login');
        }

    }
}
