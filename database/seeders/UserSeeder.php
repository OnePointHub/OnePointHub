<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        $i = 1;
        while ($i <= 15) {
            $user = User::factory()->create([
                'status' => 'active',
            ]);
            $user->assignRole('member');

            $i++;
        }

        $i = 1;
        while ($i <= 5) {
            $user = User::factory()->create([
                'status' => 'inactive',
            ]);
            $user->assignRole('member');

            $i++;
        }

        $i = 1;
        while ($i <= 5) {
            $user = User::factory()->create([
                'status' => 'pending',
            ]);
            $user->assignRole('member');

            $i++;
        }
    }
}
