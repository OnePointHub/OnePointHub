<?php

namespace Modules\Tickets\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Tickets\Enums\Priority;
use Modules\Tickets\Enums\Status;
use Modules\Tickets\Ticket;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'subject' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'priority' => $this->faker->randomElement([
                Priority::LOW,
                Priority::MEDIUM,
                Priority::HIGH,
                Priority::URGENT,
            ]),
            'status' => $this->faker->randomElement([
                Status::OPEN,
                Status::IN_PROGRESS,
                Status::RESOLVED,
                Status::CLOSED,
                Status::ON_HOLD,
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
