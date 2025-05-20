<?php

namespace App\Http\Middleware;

use Closure;

class Administrateur
{
    public function handle($request, Closure $next)
    {
        return $next($request); // Laisse passer toutes les requêtes
    }
}