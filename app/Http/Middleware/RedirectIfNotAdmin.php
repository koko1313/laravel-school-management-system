<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        if(!Auth::guard('administrator')->user()) {
            return redirect('/');
        }

        return $next($request);
    }
}