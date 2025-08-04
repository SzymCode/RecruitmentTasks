<?php

namespace App\Providers;

use App\Http\Middleware\JWTAuthenticationMiddleware;
use Illuminate\Support\ServiceProvider;

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
        $this->app['router']->aliasMiddleware('jwt.auth', JWTAuthenticationMiddleware::class);
    }
}
