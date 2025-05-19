<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Administrateur
{
  // app/Http/Middleware/RedirectIfAuthenticated.php
public function handle($request, Closure $next, ...$guards)
{
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return $next($request);
}
}