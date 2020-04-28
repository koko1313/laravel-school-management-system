<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotTeacher
{
    public function handle($request, Closure $next)
    {

        if(!Auth::guard('teacher')->user()) {
            return redirect('/');
        }

        return $next($request);
    }
}