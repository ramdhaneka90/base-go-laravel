<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $this->createRoles();

        // Credentials
        $usernameUser = 'admin';
        $emailUser = 'admin@app.com';
        $passwordUser = 'password';

        $this->command->line("");
        $this->command->line("Create Default User...");
        $user = User::where('email', $emailUser)->first();
        $dataUser = [
            'name'  => "Administrator",
            'email' => $emailUser,
            'username' => $usernameUser,
            'password'  => Hash::make($passwordUser),
            'type' => 1,
            'status' => 1,
            'email_verified_at' => now()
        ];

        if (!$user) {
            $user = User::create($dataUser);
        } else {
            $user->update($dataUser);
        }

        $this->command->line(" + Email: " .  $dataUser['email']);
        $this->command->line(" + Username: " .  $dataUser['username']);
        $this->command->line(" + Password: $passwordUser");
        $this->command->line("");

        $this->command->line("Assign Superadmin to Default User...");
        $user->assignRole('Superadmin');
    }

    private function createRoles()
    {
        $this->command->line("Make Default Role...");

        $roles = [
            'SUPER_ADMIN' => 'Superadmin'
        ];
        foreach ($roles as $key_role => $role) {
            $this->command->line("Create Role " . $role);

            $data = Role::where('name', $role)->first();
            if (!$data) {
                $data = Role::create([
                    'code' => $key_role,
                    'name' => $role, 
                    'guard_name' => 'web', 
                    'status' => 1
                ]);
            }

            $data->givePermissionTo(Permission::all());
            $data->menus()->sync(Menu::pluck('id')->toArray());
        }
    }
}
