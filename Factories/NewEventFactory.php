<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\NewEvent;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<NewEvent>
 */
class NewEventFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'sourceId' => $this->faker->uuid(),
            'userId' => $this->faker->numberBetween(1, 1000),
            'userExternalId' => $this->faker->uuid(),
            'budgetId' => $this->faker->numberBetween(1, 1000),
            'ticketId' => $this->faker->uuid(),
            'ticketNumber' => $this->faker->word(),
            'ticketType' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'customerId' => $this->faker->numberBetween(1, 1000),
            'customerExternalId' => $this->faker->uuid(),
            'eventTypeId' => $this->faker->uuid(),
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'isInternal' => $this->faker->boolean(),
        ];
    }

    protected function modelClass(): string
    {
        return NewEvent::class;
    }
}
