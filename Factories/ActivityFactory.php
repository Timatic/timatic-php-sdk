<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\Activity;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'sourceId' => $this->faker->uuid(),
            'eventTypeId' => $this->faker->uuid(),
            'customerId' => $this->faker->uuid(),
            'ticketId' => $this->faker->uuid(),
            'entrySuggestionId' => null,
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'isInternal' => null,
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return Activity::class;
    }
}
