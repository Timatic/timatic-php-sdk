<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\BudgetTimeSpentTotal;

class BudgetTimeSpentTotalFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'start' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'end' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'remainingMinutes' => $this->faker->numberBetween(15, 480),
            'periodUnit' => $this->faker->word(),
            'periodValue' => $this->faker->numberBetween(1, 100),
        ];
    }

    protected function modelClass(): string
    {
        return BudgetTimeSpentTotal::class;
    }
}
