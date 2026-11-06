<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\DataTransferObjects\Event;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'userId' => $this->faker->uuid(),
            'budgetId' => null,
            'ticketId' => $this->faker->uuid(),
            'sourceId' => $this->faker->uuid(),
            'ticketNumber' => $this->faker->word(),
            'ticketType' => null,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'customerId' => $this->faker->uuid(),
            'eventTypeId' => $this->faker->uuid(),
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'isInternal' => null,
        ];
    }

    protected function modelClass(): string
    {
        return Event::class;
    }
}
