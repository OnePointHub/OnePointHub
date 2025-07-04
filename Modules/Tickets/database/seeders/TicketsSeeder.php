<?php

namespace Modules\Tickets\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tickets\Ticket;

class TicketsSeeder extends Seeder
{
    public function run(): void
    {
        Ticket::factory(50)->create();
    }
}
