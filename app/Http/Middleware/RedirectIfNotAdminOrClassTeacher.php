<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotAdminOrClassTeacher
{
    public function handle($request, Closure $next)
    {
        //echo isset(Auth::guard('teacher')->user()->role_id) == false;
        //die();

        if(!Auth::guard('administrator')->user()) {
            if(!isset(Auth::guard('teacher')->user()->role_id) || Auth::guard('teacher')->user()->role_id != 2) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}