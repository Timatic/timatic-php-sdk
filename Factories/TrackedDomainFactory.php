<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\DataTransferObjects\TrackedDomain;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<TrackedDomain>
 */
class TrackedDomainFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'domain' => $this->faker->word(),
            'path' => null,
            'customerId' => $this->faker->numberBetween(1, 1000),
            'budgetId' => null,
            'isInternal' => $this->faker->boolean(),
            'userId' => null,
            'parentId' => null,
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return TrackedDomain::class;
    }
}
