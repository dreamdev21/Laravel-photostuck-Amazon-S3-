<?php

namespace App\Http\Middleware;

use Closure;

class Role
{

    public function handle($request, Closure $next, $role)
    {
        if (\Auth::check() && \Auth::user()->can($role)) {
          return $next($request);
        }

        return response('blank', 404);
    }
}
