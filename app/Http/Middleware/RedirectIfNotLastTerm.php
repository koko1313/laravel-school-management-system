<?php

namespace App\Http\Middleware;

use App\Models\Term;
use Closure;
use Auth;

class RedirectIfNotLastTerm
{
    public function handle($request, Closure $next)
    {

        if(!Term::getLastTerm()->now) {
            return redirect('/');
        }

        return $next($request);
    }
}