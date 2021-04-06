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

        Blade::if('roles', function ($roles) {
            return auth()->check() && auth()->user()->hasRoles($roles);
        });

        Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermissionTo($permission);
        });

        Blade::if('permissions', function ($permissions) {
            return auth()->check() && auth()->user()->hasPermissions($permissions);
        });

        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            \Log::error('PermissionsServiceProvider - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return false;
        }
    }
}
