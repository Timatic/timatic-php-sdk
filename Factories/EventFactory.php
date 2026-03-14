<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\Event;
use Timatic\Foundation\Factories\Factory;

class EventFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'userId' => $this->faker->word(),
            'budgetId' => $this->faker->word(),
            'ticketId' => $this->faker->uuid(),
            'sourceId' => $this->faker->uuid(),
            'ticketNumber' => $this->faker->word(),
            'ticketType' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'customerId' => $this->faker->uuid(),
            'eventTypeId' => $this->faker->uuid(),
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'isInternal' => $this->faker->word(),
        ];
    }

    protected function modelClass(): string
    {
        return Event::class;
    }
}
