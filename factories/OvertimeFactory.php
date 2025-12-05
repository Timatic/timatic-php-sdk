<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\Overtime;

class OvertimeFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'entryId' => $this->faker->uuid(),
            'overtimeTypeId' => $this->faker->uuid(),
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'percentages' => $this->faker->word(),
            'approvedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'approvedByUserId' => $this->faker->uuid(),
            'exportedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return Overtime::class;
    }
}
