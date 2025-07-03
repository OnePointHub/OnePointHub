<?php

namespace Modules\Roles\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'User']);

        app()['cache']->forget('spatie.permission.cache');

        $admin = User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ],
            [
                'password' => bcrypt('password'),
            ]
        );

        $admin->assignRole('Admin');
    }
}
