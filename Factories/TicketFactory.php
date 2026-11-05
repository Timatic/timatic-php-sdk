<?php

namespace Timatic\Factories;

use Timatic\Dto\Ticket;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'key' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'createdAt' => null,
            'closedAt' => null,
            'url' => $this->faker->word(),
            'customerId' => null,
            'budgetId' => null,
        ];
    }

    protected function modelClass(): string
    {
        return Ticket::class;
    }
}
