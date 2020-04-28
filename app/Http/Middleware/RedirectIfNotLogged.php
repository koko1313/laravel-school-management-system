<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotLogged
{
    public function handle($request, Closure $next)
    {

        if(!Auth::guard('administrator')->user() && !Auth::guard('teacher')->user() && !Auth::guard('student')->user()) {
            return redirect('/');
        }

        return $next($request);
    }
}