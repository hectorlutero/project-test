<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $adminDoNotInclude = [
            'company-create',
            'company-image-create',
            'product-create',
            'service-create',
            'service-gallery-create',
            'user-address-create'
        ];
        $adminRole->givePermissionTo(Permission::whereNotIn('name', $adminDoNotInclude)->get());

        $clientRole = Role::create(['name' => 'client']);
        $partnerRole = Role::create(['name' => 'partner']);
        $partnerRoleInclude = [
            'user-address-list',
            'user-address-create',
            'user-address-edit',
            'user-address-delete',
            'plan-list',
            'business-list'
        ];
        $partnerRole->givePermissionTo(Permission::whereIn('name', $partnerRoleInclude)->get());

       $motoboyRole = Role::create(['name' => 'motoboy']);

    }
}
