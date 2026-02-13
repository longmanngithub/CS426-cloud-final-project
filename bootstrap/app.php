<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        
        // Register custom middleware aliases
        $middleware->alias([
            'token.user' => \App\Http\Middleware\EnsureTokenIsUser::class,
            'token.organizer' => \App\Http\Middleware\EnsureTokenIsOrganizer::class,
            'token.admin' => \App\Http\Middleware\EnsureTokenIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if (($request->expectsJson() || $request->is('api/*')) && $e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }
            
            if ($e instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException && str_contains($e->getMessage(), 'login')) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }
        });
    })->create();
