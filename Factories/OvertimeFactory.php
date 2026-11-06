<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\DataTransferObjects\Overtime;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<Overtime>
 */
class OvertimeFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'entryId' => $this->faker->numberBetween(1, 1000),
            'overtimeTypeId' => $this->faker->uuid(),
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'percentages' => [],
            'approvedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'approvedByUserId' => null,
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
