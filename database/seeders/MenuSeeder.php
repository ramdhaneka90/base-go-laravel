<?php

namespace Database\Seeders;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Permission;

class MenuSeeder extends Seeder
{
    /**
     * Collection menu.
     *
     * @return array
     */
    public static function listMenu()
    {
        return [
            [
                'code' => 'home',
                'name' => 'Beranda',
                'custom_url' => 0,
                'url' => 'home',
                'icon' => 'fas fa-home',
                'category' => 'admin',
                'sequence' => 0,
                'permissions' => ['index'],
            ],
            [
                'code' => 'master',
                'name' => 'Master Data',
                'custom_url' => 1,
                'url' => '#',
                'icon' => 'fas fa-cogs',
                'category' => 'admin',
                'sequence' => 8,
                'permissions' => ['index'],
                'childrens' => [
                    [
                        'code' => 'menu',
                        'name' => 'Menu',
                        'custom_url' => 0,
                        'url' => 'menu.index',
                        'icon' => 'fas fa-bars',
                        'category' => 'admin',
                        'sequence' => 0,
                        'permissions' => ['index', 'create', 'edit', 'delete'],
                    ],
                    [
                        'code' => 'aksesData',
                        'name' => 'Hak Akses',
                        'custom_url' => 0,
                        'url' => 'role.index',
                        'icon' => 'fas fa-user-lock',
                        'category' => 'admin',
                        'sequence' => 1,
                        'permissions' => ['index', 'create', 'edit', 'delete'],
                    ],
                    [
                        'code' => 'region',
                        'name' => 'Wilayah',
                        'custom_url' => 0,
                        'url' => 'region.index',
                        'icon' => 'fas fa-warehouse',
                        'category' => 'admin',
                        'sequence' => 0,
                        'permissions' => ['index', 'create', 'edit', 'delete'],
                    ],
                    [
                        'code' => 'area',
                        'name' => 'Area',
                        'custom_url' => 0,
                        'url' => 'area.index',
                        'icon' => 'fas fa-warehouse',
                        'category' => 'admin',
                        'sequence' => 0,
                        'permissions' => ['index', 'create', 'edit', 'delete'],
                    ],
                    [
                        'code' => 'division',
                        'name' => 'Divisi',
                        'custom_url' => 0,
                        'url' => 'division.index',
                        'icon' => 'fas fa-warehouse',
                        'category' => 'admin',
                        'sequence' => 0,
                        'permissions' => ['index', 'create', 'edit', 'delete'],
                    ],
                    [
                        'code' => 'position',
                        'name' => 'Posisi',
                        'custom_url' => 0,
                        'url' => 'position.index',
                        'icon' => 'fas fa-warehouse',
                        'category' => 'admin',
                        'sequence' => 0,
                        'permissions' => ['index', 'create', 'edit', 'delete'],
                    ],
                    [
                        'code' => 'user',
                        'name' => 'User',
                        'custom_url' => 0,
                        'url' => 'user.index',
                        'icon' => 'fas fa-users',
                        'category' => 'admin',
                        'sequence' => 2,
                        'permissions' => ['index', 'create', 'edit', 'delete'],
                    ],
                ]
            ],
            [
                'code' => 'tools',
                'name' => 'Tools',
                'custom_url' => 1,
                'url' => '#',
                'icon' => 'fas fa-server',
                'category' => 'admin',
                'sequence' => 9,
                'permissions' => ['index'],
                'childrens' => [
                    [
                        'code' => 'activitylog',
                        'name' => 'Log Aktivitas',
                        'custom_url' => 0,
                        'url' => 'activitylog.index',
                        'icon' => 'fas fa-file-code',
                        'category' => 'admin',
                        'sequence' => 1,
                        'permissions' => ['index'],
                    ]
                ]
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line("Make Menus...");
        $menus = $this->listMenu();

        $this->processMenu($menus);
    }

    private function processMenu(array $menus, $parent_id = NULL, $parent_code = NULL)
    {
        $sequence = 0;
        foreach ($menus as $menu) {
            $currentCode = $menu['code'];

            $sequence++;

            $menu['parent_id'] = $parent_id;
            $menu['sequence'] = $sequence;

            $query = Menu::where('name', $menu['name'])->where('url', $menu['url'])->first();
            $childrens = isset($menu['childrens']) ? $menu['childrens'] : NULL;
            $permissions = $menu['permissions'];

            // Get ids permission
            $menuPermissionData = [];
            foreach ($permissions as $index => $value) {
                $permissionName = $currentCode . '-' . $value;
                $queryPermission = Permission::where('name', $permissionName)->first();

                if ($queryPermission != null) {
                    $menuPermissionData[] = [
                        'permission_id' => $queryPermission->id,
                        'name' => getListPermissionName()[$value],
                        'sequence' => $index,
                    ];
                }
            }

            unset($menu['childrens']);
            unset($menu['permissions']);

            if (!$query) {
                $id = Uuid::generate()->string;
                $menu['id'] = $id;

                $query = Menu::createOne($menu, function ($query, $event) use ($menuPermissionData) {
                    $event->permissions()->attach($menuPermissionData);
                });
            } else {
                $id = $query->id;

                $query = Menu::updateOne($id, $menu, function ($query, $event, $cursor) use ($menuPermissionData) {
                    $cursor->permissions()->detach();
                    $cursor->permissions()->sync($menuPermissionData);
                });
            }

            if ($childrens) {
                self::processMenu($childrens, decrypt($query['data']['id']), $currentCode);
            }
        }
    }
}
