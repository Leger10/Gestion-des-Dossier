<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        'administrateur' => \App\Http\Middleware\Administrateur::class,
             'Superviseur' => \App\Http\Middleware\RedirectIfAuthenticated::class,
             'Agent' => \App\Http\Middleware\Utilisateur::class,
    ];
// Ajoutez cette ligne dans la propriété $middlewareAliases
protected $middlewareAliases = [
    // ...
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'throttle.api' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
];


    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
    // Middleware d'authentification de base
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth' => \App\Http\Middleware\Authenticate::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // Assurez-vous que cette ligne existe
    'user' => \App\Http\Middleware\Utilisateur::class,
    'admin' => \App\Http\Middleware\Administrateur::class,
                \Illuminate\Http\Middleware\HandleCors::class, 
    /*
     * Autres middlewares désactivés
     *
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    // 'admin' => \App\Http\Middleware\Administrateur::class,
    // 'user' => \App\Http\Middleware\Utilisateur::class,
    // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    
    // Anciennes implémentations commentées
    // 'utilisateur' => \App\Http\Middleware\Utilisateur::class,
    // 'admin' => \App\Http\Middleware\Administrateur::class,
    // 'Superviseur' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    // 'Agent' => \App\Http\Middleware\Utilisateur::class,
    // 'web' => [
    //     \App\Http\Middleware\Administrateur::class,
    // ],
    // 'Superviseur' => [
    //     \App\Http\Middleware\RedirectIfAuthenticated::class,
    // ],
    // 'Agent' => [
    //     \App\Http\Middleware\Utilisateur::class,
    // ],
    */
];

    
    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
