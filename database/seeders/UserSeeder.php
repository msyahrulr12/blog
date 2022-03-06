<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123')
        ]);
        $user->assignRole('Super Admin');

        $role = Role::findByName('Super Admin');
        $role->givePermissionTo('Role index');
        $role->givePermissionTo('Role create');
        $role->givePermissionTo('Role show');
        $role->givePermissionTo('Role edit');
        $role->givePermissionTo('Role delete');

        $role->givePermissionTo('Permission index');
        $role->givePermissionTo('Permission create');
        $role->givePermissionTo('Permission show');
        $role->givePermissionTo('Permission edit');
        $role->givePermissionTo('Permission delete');
    }
}
