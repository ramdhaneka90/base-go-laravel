<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

use App\Bases\BaseService;
use App\Models\Role as Model;
use App\Models\Menu;
use App\Models\Permission;
use App\Services\MenuService;

class RoleService extends BaseService
{
    public static function data($data)
    {
        $query = Model::data();
        return DataTables::of($query)
            ->filter(function ($query) use ($data) {
                if ($data['name'] != '')
                    $query->whereLike('name', $data['name']);

                if ($data['status'] != '')
                    $query->where('status', $data['status']);
            })
            ->addIndexColumn()
            ->addColumn('id', function ($query) {
                return encrypt($query->id);
            })
            ->addColumn('checkbox', function ($query) {
                return true;
            })
            ->make(true)
            ->getData(true);
    }

    public static function store($data)
    {
        $permissions = Permission::with('menus')->whereIn('id', $data['permissions'])->get();

        return Model::transaction(function () use ($data, $permissions) {
            $visibilities = [];
            foreach ($permissions as $item) {
                $arrName = explode('-', $item->name);
                $suffix = end($arrName);
                if ($suffix == 'index') {
                    $menu = !empty($item->menus[0]) ? $item->menus[0] : null;
                    if ($menu != null) {
                        $visibilities[] = $menu->id;
                    }
                }
            }

            return Model::createOne([
                'code'        => $data['code'],
                'name'        => $data['name'],
                'guard_name'  => 'web',
                'description' => $data['description'],
                'status'      => $data['status'] ? 1 : 0,
            ], function ($query, $event) use ($data, $visibilities) {
                $event->permissions()->attach(is_array($data['permissions']) ? $data['permissions'] : []);
                $event->menus()->sync(is_array($visibilities) ? $visibilities : []);

                // Forgot Cache Permission
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            });
        });
    }

    public static function get($id = null)
    {
        if (!empty($id))
            $query = Model::find($id);
        else
            $query = Model::all();

        if ($query) {
            return $query;
        }

        return false;
    }

    public static function update($id, $data)
    {
        $permissions = Permission::with('menus')->whereIn('id', $data['permissions'])->get();

        return Model::transaction(function () use ($id, $data, $permissions) {
            $visibilities = [];
            foreach ($permissions as $item) {
                $arrName = explode('-', $item->name);
                $suffix = end($arrName);
                if ($suffix == 'index') {
                    $menu = !empty($item->menus[0]) ? $item->menus[0] : null;
                    if ($menu != null) {
                        $visibilities[] = $menu->id;
                    }
                }
            }

            return Model::updateOne($id, [
                'code'        => $data['code'],
                'name'        => $data['name'],
                'description' => $data['description'],
                'status'      => $data['status']  ? 1 : 0,
            ], function ($query, $event, $cursor) use ($data, $visibilities) {
                $cursor->permissions()->sync(is_array($data['permissions']) ? $data['permissions'] : []);
                $cursor->menus()->sync(is_array($visibilities) ? $visibilities : []);

                // Forgot Cache Permission
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            });
        });
    }

    public static function destroy($id)
    {
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

    public static function getMenus($data)
    {
        $cursors = Menu::orderBy('sequence')->get();
        $menus = [];

        foreach ($cursors as $cursor) {
            $parent_id = !empty($cursor->parent_id) ? $cursor->parent_id : 0;
            $menus[$parent_id][] = $cursor;
        }

        $results = count($menus) > 0 ? MenuService::parsingMenu($menus) : [];
        return self::outputResult($results);
    }

    public static function hasPermissions($id)
    {
        $menu = Model::find($id);
        $permissions = [];
        if ($menu) {
            foreach ($menu->permissions->sortBy(function ($q) {
                return $q->pivot->sequence;
            }) as $permission) {
                $pivot = $permission->pivot;
                $permissions[] = $permission->id;
            }
        }
        return $permissions;
    }

    public static function hasVisibilities($id)
    {
        $menu = Model::find($id);
        $visibilities = [];
        if ($menu) {
            foreach ($menu->menus as $menu) {
                $pivot = $menu->pivot;
                $visibilities[] = $menu->id;
            }
        }
        return $visibilities;
    }

    public static function dropdown($default = '')
    {
        $results = [];

        $cursors = Model::isActive()->get();
        foreach ($cursors as $cursor) {
            $results[$cursor->id] = $cursor->name;
        }

        return $results;
    }

    public static function roleOptions()
    {
        $roles = [];
        $cursors = Model::isActive()->get();

        foreach ($cursors as $cursor) {
            $roles[$cursor->name] = $cursor->name;
        }

        return $roles;
    }
}
