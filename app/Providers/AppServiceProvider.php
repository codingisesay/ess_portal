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
    // Force HTTPS only in production
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
    // Optionally, force root URL only in production
    if ($this->app->environment('production')) {
        URL::forceRootUrl(config('app.url'));
    }
 
    // Pagination setup (choose only one)
    Paginator::useBootstrapFive();
    
    // Force paginator to always use correct base path
    Paginator::currentPathResolver(function () {
        return url()->current();
    });
 
    // Override asset() if needed
    URL::macro('asset', function ($path, $secure = null) {
        return url($path, $secure);
    });
}
}