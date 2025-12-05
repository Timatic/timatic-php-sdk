<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\TimeSpentTotal;

class TimeSpentTotalFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'start' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'end' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'internalMinutes' => $this->faker->numberBetween(15, 480),
            'billableMinutes' => $this->faker->numberBetween(15, 480),
            'periodUnit' => $this->faker->word(),
            'periodValue' => $this->faker->numberBetween(1, 100),
        ];
    }

    protected function modelClass(): string
    {
        return TimeSpentTotal::class;
    }
}
