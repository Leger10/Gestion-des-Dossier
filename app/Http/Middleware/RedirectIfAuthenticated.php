<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        // Version simplifiée sans redirection
        return $next($request);
    }
}