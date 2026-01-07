<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\VerifyN8nToken; // Añade esta línea

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',  // Asegúrate que esta línea existe
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Crear un grupo de middleware específico para n8n
        $middleware->appendToGroup('n8n-api', [
            'auth:sanctum',
            VerifyN8nToken::class,
        ]);

        // Opcional: Si quieres que TODAS las rutas API usen Sanctum
        // $middleware->api(prepend: [
        //     'auth:sanctum',
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
