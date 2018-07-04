<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;


class Permission
{
    public function handle($request, Closure $next, $permission)
    {
        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);
        foreach ($permissions as $permission) {
            $guardPermission = explode('_', $permission);
             if(count($guardPermission) > 1){
                 if (app('auth')->user()->hasPermissionTo($guardPermission[0],$guardPermission[1])) {
                     return $next($request);
                 }
             } else {
                 if (app('auth')->user()->can($permission)) {
                     return $next($request);
                 }
             }

        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
