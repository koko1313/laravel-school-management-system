<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNot
{
    public function handle($request, Closure $next, $role)
    {
        if(!Auth::guard($role)->user()) {
            return redirect('/');
        }

        return $next($request);
    }
}