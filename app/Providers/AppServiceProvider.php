<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        // Force Laravel to use gateway prefix
        URL::forceRootUrl(config('app.url'));
        URL::forceScheme('https');

        // Pagination setup
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        // Override the asset() behavior globally
        // This ensures asset() always prepends APP_URL
        URL::macro('asset', function ($path, $secure = null) {
            return url($path, $secure);
        });
    }
}