<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {

            // Default fallback
            $displayOrgName = 'Company Name';

            if (Auth::guard('superadmin')->check()) {
                $organisation = Auth::guard('superadmin')->user();

                // 👇 organisation model already loaded
                if (!empty($organisation->name)) {
                    $displayOrgName = Str::before($organisation->name, '.');
                }
            }

            $view->with('displayOrgName', $displayOrgName);
        });
    }
}
