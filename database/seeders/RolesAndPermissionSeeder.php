<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offersEdit = Permission::create(['name' => 'edit articles']);
        $offersDelete = Permission::create(['name' => 'delete articles']);

        $writer = Role::create(['name' => 'writer']);

        $writer->syncPermissions([
            $offersEdit,
            $offersDelete
        ]);

    }
}
