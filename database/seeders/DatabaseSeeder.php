<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            UserSeeder::class,
        ]);

        $user = User::factory()->create([
            'email' => 'admin@admin.com',
        ]);

        $user->assignRole('admin');

        $unverified = User::factory()->unverified()->create([
            'email' => 'unverified@example.com',
        ]);

        $unverified->assignRole('member');
    }
}
