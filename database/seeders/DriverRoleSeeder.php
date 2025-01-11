<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DriverRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $driver = Role::create(['name' => 'driver']);

        $permission = Permission::create(['name' => 'access-driver-features']);

        $driver->givePermissionTo($permission);

    }
}
