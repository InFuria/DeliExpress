<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Gate;
use App\Permission;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     */
    public function boot()
    {
        //Blade directives

        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        Blade::if('anyRole', function ($roles) {
            return auth()->check() && auth()->user()->hasAnyRole($roles);
        });

        Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermissionTo($permission);
        });

        Blade::if('permissions', function ($permissions) {
            return auth()->check() && auth()->user()->hasPermissions($permissions);
        });

    }
}
