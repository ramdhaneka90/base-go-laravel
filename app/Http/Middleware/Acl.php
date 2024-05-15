<?php

namespace App\Http\Middleware;

use App\Services\MenuService;
use Closure;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $whitelist = config('acl.whitelist');
        $route_name = $request->route()->getName();

        if (!in_array($route_name, $whitelist)) {

            // Get role permission from user login
            $listRolePermission = auth()->user()->roles->first()->permissions->transform(function ($item) {
                return $item->name;
            })->toArray();

            // Get controller instance
            $controller = $request->route()->controller;

            // Get permission list from controller
            $permissionListController = !empty($controller->permissionList) ? $controller->permissionList : [];

            // Check wether permission list in controller was declare ?
            if (!empty($permissionListController)) {

                // Get module name controller
                $moduleController = $controller->module;

                // Get target method controller
                $targetMethodController = explode('@', $request->route()->action['controller'])[1];

                // Get current permission name
                $currentPermissionName = null;
                foreach ($permissionListController as $key => $item) {
                    if (in_array($targetMethodController, $item)) {
                        $currentPermissionName = $moduleController . '-' . $key;
                        break;
                    }
                }

                // If permission name isn't empty, check validation permission
                if ($currentPermissionName != null) {
                    if (!in_array($currentPermissionName, $listRolePermission)) {
                        abort(403);
                    }
                }
            }
        }

        return $next($request);
    }
}
