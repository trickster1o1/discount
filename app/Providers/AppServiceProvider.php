<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('menuPermissionRoles', function () {
            if (auth()->user()->role != NULL) {
                return auth()->user()->load('role')->role->load('menuPermissionRoles')->menuPermissionRoles;
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('authorized', function ($menuCode, $permissionCode = '') {
            return is_authorized($menuCode, $permissionCode);
        });
        Paginator::useBootstrap();
    }
}
