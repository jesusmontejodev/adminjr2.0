<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\VerifyN8nToken;
use App\Http\Middleware\VerificarSuscripcion;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Crear un grupo de middleware específico para n8n
        $middleware->appendToGroup('n8n-api', [
            'auth:sanctum',
            VerifyN8nToken::class,
        ]);

        // Registrar middleware alias
        $middleware->alias([
            'verificar.suscripcion' => VerificarSuscripcion::class,
            'suscripcion' => VerificarSuscripcion::class,
        ]);

        // Middleware para rutas API
        $middleware->api(prepend: [
            // Middlewares que se aplican antes a todas las rutas API
        ], append: [
            // Middlewares que se aplican después a todas las rutas API
        ]);

        // Middleware para rutas Web
        $middleware->web(append: [
            // Middlewares para rutas web
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
