<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Role index'
        ]);
        Permission::create([
            'name' => 'Role create'
        ]);
        Permission::create([
            'name' => 'Role show'
        ]);
        Permission::create([
            'name' => 'Role edit'
        ]);
        Permission::create([
            'name' => 'Role delete'
        ]);


        Permission::create([
            'name' => 'Permission index'
        ]);
        Permission::create([
            'name' => 'Permission create'
        ]);
        Permission::create([
            'name' => 'Permission show'
        ]);
        Permission::create([
            'name' => 'Permission edit'
        ]);
        Permission::create([
            'name' => 'Permission delete'
        ]);
    }
}
