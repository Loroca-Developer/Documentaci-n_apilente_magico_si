<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\JwtCookieMiddleware;
use Tymon\JWTAuth\Http\Middleware\Authenticate;
use Tymon\JWTAuth\Http\Middleware\RefreshToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware para grupos
        $middleware->group('api',[
           // \Illumuminate\Routing\Middlewarre\TrhottleRequests::class. 'api', se quita por que no tiene la tabla cache 
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
           ]);

           // si usa el middleware de cookie
           $middleware->appendToGroup('api', JwtCookieMiddleware::class);

           //middleware alias para usar en rutas
           $middleware->alias([
            'jwt.auth' => Authenticate::class,
            'jwt.refresh' => RefreshToken::class,
           ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
