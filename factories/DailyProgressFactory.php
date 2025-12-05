<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\DailyProgress;

class DailyProgressFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'userId' => $this->faker->uuid(),
            'date' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'progress' => $this->faker->word(),
        ];
    }

    protected function modelClass(): string
    {
        return DailyProgress::class;
    }
}
