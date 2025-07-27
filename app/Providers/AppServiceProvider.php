<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Importar la fachada URL

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // FORZAR HTTPS para todas las URLs generadas por Laravel
        // Esto es crucial cuando la aplicación está detrás de un proxy SSL/TLS (como Railway)
        if (env('APP_ENV') === 'production') { // Aplicar solo en producción
            URL::forceScheme('https');
        }
    }
}
