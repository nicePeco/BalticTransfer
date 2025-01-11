<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);

        $permissions = [
            'manage users',
            'manage drivers',
            'manage rides',
            'manage payments',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole->givePermissionTo(Permission::all());

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'niklavs@niklavs',
            'password' => bcrypt('niklavs30'),
        ]);

        $admin->assignRole($adminRole);
    }
}
