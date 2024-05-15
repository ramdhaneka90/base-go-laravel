<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Webpatser\Uuid\Uuid;
use App\Models\Permission;
use Database\Seeders\MenuSeeder;

class Acl extends Command
{
    private $listPermission = ['index', 'show', 'create', 'edit', 'delete', 'approve', 'export', 'execute'];
    private $listInsertPermission = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate permission from routes name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('');
        $this->info('[ Generate Permission ]');
        if ($this->confirm('Do you wish to continue?')) {

            $this->processPermissions(MenuSeeder::listMenu());
            Permission::insert($this->listInsertPermission);

            $this->info('Complete..');
        }
    }

    private function processPermissions($listMenu = [], $parentCode = null)
    {
        foreach ($listMenu as $menu) {
            $listPermission = $this->listPermission;
            $hasChildren = !empty($menu['childrens']);
            $currentCode = $menu['code'];

            if ($hasChildren) $listPermission = ['index'];

            foreach ($listPermission as $permission) {
                $this->listInsertPermission[] = [
                    'id' => Uuid::generate()->string,
                    'name' => $currentCode . '-' . $permission,
                    'guard_name' => 'web',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }

            if ($hasChildren) {
                $this->processPermissions($menu['childrens'], $currentCode);
            }
        }
    }
}
