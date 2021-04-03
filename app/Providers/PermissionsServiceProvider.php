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
        Blade::directive('role', function ($role) {

            return "if(auth()->check() && auth()->user()->hasRole({$role})) :"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function ($role) {
            return "endif;"; //return this endif statement inside php tag
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
