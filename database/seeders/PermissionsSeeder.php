<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        Permission::create(['name' => 'invite member']);
        Permission::create(['name' => 'manage team']);

        // Create Roles and Assign Permissions
        $superAdmin = Role::create(['name' => 'super-admin']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo('invite member');
        $admin->givePermissionTo('manage team');

        $member = Role::create(['name' => 'member']);
    }
}
