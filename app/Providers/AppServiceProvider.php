<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // útil si trabajas con MySQL viejo

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Aquí puedes registrar bindings, singletons o paquetes
        // Ejemplo: $this->app->singleton(MiServicio::class, function() { return new MiServicio(); });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Código que se ejecuta en cada request

        // Por ejemplo, para evitar errores con claves largas en MySQL
        Schema::defaultStringLength(191);

        // O registrar macros, eventos globales, etc.
    }
}
