<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
            \App\Http\Middleware\CheckUserExists::class,
        ]);
        
        $middleware->alias([
            'auth.user' => \App\Http\Middleware\EnsureUserAuthenticated::class,
            'auth.organizer' => \App\Http\Middleware\EnsureOrganizerAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
