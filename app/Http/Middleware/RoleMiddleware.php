<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(!$request->user()->hasRole($role) || $permission !== null && !$request->user()->can($permission)) {

            return redirect()->back()->with('toast_error', 'No posse los permisos necesarios.');
        }

        return $next($request);
    }
}
