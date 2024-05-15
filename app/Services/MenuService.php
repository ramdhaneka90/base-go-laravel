<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\Bases\BaseService;
use App\Models\Permission;
use App\Models\Menu as Model;

class MenuService extends BaseService
{
    public static function data($data)
    {
        $cursors = Model::orderBy('sequence')->get();
        $menus = [];

        foreach ($cursors as $cursor) {
            $parent_id = !empty($cursor->parent_id) ? $cursor->parent_id : 0;
            $menus[$parent_id][] = $cursor;
        }

        $results = count($menus) > 0 ? self::parsingMenu($menus) : [];
        return self::outputResult($results);
    }

    public static function parsingMenu($menus, $parent_id = 0, $route = true)
    {
        $results = [];

        if (!empty($menus[$parent_id])) {
            foreach ($menus[$parent_id] as $menu) {
                $url = $menu->custom_url ? $menu->url : (($route) ? route($menu->url) : $menu->url);
                $data = [
                    'id'    => encrypt($menu->id),
                    'label' => $menu->name,
                    'custom_url' => $menu->custom_url,
                    'url'   => $url,
                    'icon'  => $menu->icon,
                    'slug'  => $menu->url,
                    'permissions' => MenuService::hasPermissions($menu->id)
                ];

                if (isset($menus[$menu->id])) {
                    $data['children'] = self::parsingMenu($menus, $menu->id);
                }

                $results[] = $data;
            }
        }

        return $results;
    }

    public static function store($data)
    {
        return Model::transaction(function () use ($data) {
            return Model::createOne([
                'custom_url'      => $data['custom_url'] ? 1 : 0,
                'code'            => $data['code'],
                'name'            => $data['name'],
                'url'             => $data['custom_url'] ? $data['url'] : $data['route'],
                'icon'            => $data['icon'],
                'description'     => $data['description'],
                'category'        => $data['category'],
                'parent_id'       => !empty($data['parent_id']) ? decrypt($data['parent_id']) : NULL,
            ], function ($query, $event) use ($data) {
                $features = [];
                $index = 0;
                if (!empty($data['features'])) {
                    foreach ($data['features'] as $item) {
                        $permissionName = ($data['code'] . '-' . $item['permission_id']);
                        $permissionId = null;

                        $permission = Permission::where('name', $permissionName)->first();
                        if ($permission == null) {
                            $store = new Permission;
                            $store->name = $permissionName;
                            $store->guard_name = 'web';
                            $store->save();

                            $permissionId = $store->id;
                        } else {
                            $permissionId = $permission->id;
                        }

                        $features[] = [
                            'name' => getListPermissionName()[$item['permission_id']],
                            'permission_id' => $permissionId,
                            'sequence' => $index,
                        ];

                        $index++;
                    }
                }

                $event->permissions()->attach($features);
            });
        });
    }

    public static function get($id)
    {
        $query = Model::find($id);
        if ($query) {
            return $query;
        }

        return false;
    }

    public static function update($id, $data)
    {
        return Model::transaction(function () use ($id, $data) {
            return Model::updateOne($id, [
                'custom_url'      => $data['custom_url'] ? 1 : 0,
                'code'            => $data['code'],
                'name'            => $data['name'],
                'url'             => $data['custom_url'] ? $data['url'] : $data['route'],
                'icon'            => $data['icon'],
                'description'     => $data['description'],
                'parent_id'       => !empty($data['parent_id']) ? decrypt($data['parent_id']) : NULL,
            ], function ($query, $event, $cursor) use ($data) {
                $cursor->permissions()->detach();

                $features = [];
                if (!empty($data['features'])) {
                    $index = 0;
                    foreach ($data['features'] as $item) {
                        $permissionName = ($data['code'] . '-' . $item['permission_id']);
                        $permissionId = null;

                        $permission = Permission::where('name', $permissionName)->first();
                        if ($permission == null) {
                            $store = new Permission;
                            $store->name = $permissionName;
                            $store->guard_name = 'web';
                            $store->save();

                            $permissionId = $store->id;
                        } else {
                            $permissionId = $permission->id;
                        }

                        $features[] = [
                            'name' => getListPermissionName()[$item['permission_id']],
                            'permission_id' => $permissionId,
                            'sequence' => $index,
                        ];

                        $index++;
                    }
                }

                $cursor->permissions()->sync($features);
            });
        });
    }

    public static function destroy($id)
    {
        $query = Model::where('parent_id', $id)->count();
        if ($query) {
            return self::outputResult([], 422, __("Oops! Menu tidak dapat dihapus, karena memiliki turunan."));
        }

        return Model::deleteOne($id);
    }

    public static function destroys($data)
    {
        $id = [];
        foreach ($data->id as $value) {
            $id[] = decrypt($value);
        }

        return Model::transaction(function () use ($id) {
            return Model::deleteBatch($id);
        });
    }

    public static function getRoutesAdmin($default = null)
    {

        $routeCollection = Route::getRoutes();
        $routes = [];
        if (!empty($default)) {
            $routes = ['' => $default];
        }

        foreach ($routeCollection as $route) {
            $route_name = $route->getName();

            if (!empty($route_name)) {
                if (in_array('GET', $route->methods()) && count($route->parameterNames()) == 0) {
                    $routes[$route_name] = $route_name;
                }
            }
        }
        return $routes;
    }

    public static function getPermission($default = null)
    {
        $cursors = Permission::all();
        $permissions = [];
        if (!empty($default)) {
            $permissions = ['' => $default];
        }

        foreach ($cursors as $cursor) {
            $permissions[$cursor->id] = $cursor->name;
        }
        return $permissions;
    }

    public static function saveOrder($data)
    {
        return Model::transaction(function () use ($data) {
            $sequences = json_decode($data['sequence']);

            if (is_array($sequences)) {
                self::setMenu($sequences);
            }

            return self::outputResult($sequences);
        });
    }

    public static function setMenu($sequences, $parent_id = null)
    {
        foreach ($sequences as $key => $value) {
            $id = decrypt($value->id);
            Model::updateOne($id, [
                'sequence'  => $key,
                'parent_id' => $parent_id
            ]);

            if (isset($value->children)) {
                self::setMenu($value->children, $id);
            }
        }
    }

    public static function hasPermissions($id)
    {
        $menu = Model::with('permissions')->find($id);
        $permissions = [];
        if ($menu) {
            foreach ($menu->permissions->sortBy(function ($q) {
                return $q->pivot->sequence;
            }) as $permission) {
                $arrPermissionName = explode('-', $permission->name);
                $codePermission = end($arrPermissionName);
                $pivot = $permission->pivot;

                $permissions[] = [
                    'id' => $permission->id,
                    'name' => $pivot->name,
                    'code' => $codePermission
                ];
            }
        }

        return $permissions;
    }

    public static function generateMenu($category = 'admin')
    {
        $_menus = [];

        $auth = auth()->user();
        if ($auth != null) {
            $auth = $auth->load('roles.menus');
            if (!empty($auth->roles->first())) {
                $cursors = $auth->roles->first()->menus;

                foreach ($cursors as $menu) {
                    $parent_id = !empty($menu->parent_id) ? $menu->parent_id : 0;
                    $_menus[$parent_id][] = $menu;
                }

                return self::parsingMenu($_menus, 0, false);
            } else {
                return $_menus;
            }
        }
    }

    public static function getMenuByUrl($url)
    {
        $cursors = DB::table('menus', 'a')
            ->select([
                'a.id', 'a.url', 'a.name', 'b.name as parent_name', 'b.url as parent_url'
            ])
            ->leftJoin('menus as b', function ($q) use ($url) {
                $q->on('b.id', '=', 'a.parent_id');
            })
            ->whereIn('a.url', $url)->first();

        return $cursors;
    }
}
