<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OfertaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    // public function register()
    // {
    //     $this->app->bind(
    //         \App\Contracts\OfertaServiceInterface::class,
    //         \App\Services\OfertasGeneralesService::class,
    //         \App\Services\OfertasPersonalizadasService::class,
    //     );
    // }
    public function register()
    {
        $this->app->bind(\App\Contracts\OfertaServiceInterface::class, function ($app) {
            if (auth()->check()) {
                return new \App\Services\OfertasPersonalizadasService();
            } else {
                return new \App\Services\OfertasGeneralesService();
            }
        });
    }
    


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
