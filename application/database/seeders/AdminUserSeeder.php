<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        $admin = User::create([
            'is_admin' => 'Y',
            'is_active' => 'Y',
            'name' => 'Admin',
            'email' => 'admin@pedequevem.com.br',
            'phone' => '3199999-9999',
            'document' => '11111111111',
            'password' => bcrypt('123456789')
        ]);
        $role = Role::findByName('admin');
        $admin->assignRole([$role->id]);

        $partner = User::create([
            'is_admin' => 'N',
            'is_active' => 'Y',
            'name' => 'Partner',
            'email' => 'partner@pedequevem.com.br',
            'phone' => '3199999-9999',
            'document' => '22222222222',
            'password' => bcrypt('123456789')
        ]);
        $role = Role::findByName('partner');
        $partner->assignRole([$role->id]);

        $partner = User::create([
            'is_admin' => 'N',
            'is_active' => 'Y',
            'name' => 'Customer',
            'email' => 'customer@pedequevem.com.br',
            'phone' => '3199999-9999',
            'document' => '33333333333',
            'password' => bcrypt('123456789')
        ]);
        $role = Role::findByName('client');
        $partner->assignRole([$role->id]);

    }
}