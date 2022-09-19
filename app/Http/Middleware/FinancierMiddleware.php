<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FinancierMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if(checkProfil(['ADMIN','FINANCIER'])){
            return $next($request);
        }else{
            return redirect('/auth/login');
        }

    }
}
