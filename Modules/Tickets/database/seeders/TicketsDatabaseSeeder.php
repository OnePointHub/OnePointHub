<?php

namespace Modules\Tickets\Database\Seeders;

use Illuminate\Database\Seeder;

class TicketsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            TicketsPermissionsSeeder::class,
            TicketsSeeder::class,
        ]);
    }
}
