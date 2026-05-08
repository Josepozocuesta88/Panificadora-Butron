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
            $user = auth()->user();

            if (is_null($user) || is_null($user->usuofecod)) {
                return new \App\Services\OfertasGeneralesService();
            } else {
                return new \App\Services\OfertasPersonalizadasService();
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
