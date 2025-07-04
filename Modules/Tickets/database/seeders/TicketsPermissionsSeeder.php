<?php

namespace Modules\Tickets\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TicketsPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset Cached Roles & Permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        Permission::firstOrCreate(['name' => 'tickets.view', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.create', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.update', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.delete', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.restore', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.forceDelete', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.assign', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.close', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.open', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.edit_admins', 'module' => 'Tickets']);
        Permission::firstOrCreate(['name' => 'tickets.edit_users', 'module' => 'Tickets']);

        // Create Roles & Assign Existing Permissions
        $role1 = Role::firstOrCreate(['name' => 'tickets.super-admin']);
        $this->assignPermissions($role1);
        $role1->givePermissionTo('tickets.edit_admins');

        $role2 = Role::firstOrCreate(['name' => 'tickets.admin']);
        $this->assignPermissions($role2);

        $role3 = Role::firstOrCreate(['name' => 'tickets.agent']);
        $role3->givePermissionTo('tickets.view');
        $role3->givePermissionTo('tickets.create');
        $role3->givePermissionTo('tickets.update');
        $role3->givePermissionTo('tickets.close');
        $role3->givePermissionTo('tickets.open');
    }

    /**
     * Assign permissions to roles.
     */
    protected function assignPermissions(Role $role): void
    {
        $role->givePermissionTo('tickets.view');
        $role->givePermissionTo('tickets.create');
        $role->givePermissionTo('tickets.update');
        $role->givePermissionTo('tickets.delete');
        $role->givePermissionTo('tickets.restore');
        $role->givePermissionTo('tickets.forceDelete');
        $role->givePermissionTo('tickets.assign');
        $role->givePermissionTo('tickets.close');
        $role->givePermissionTo('tickets.open');
        $role->givePermissionTo('tickets.edit_users');
    }
}
