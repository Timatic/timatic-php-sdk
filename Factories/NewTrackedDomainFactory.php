<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\NewTrackedDomain;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<NewTrackedDomain>
 */
class NewTrackedDomainFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'domain' => $this->faker->word(),
            'path' => null,
            'customerId' => $this->faker->numberBetween(1, 1000),
            'budgetId' => null,
            'isInternal' => $this->faker->boolean(),
            'userId' => $this->faker->numberBetween(1, 1000),
            'parentId' => null,
        ];
    }

    protected function modelClass(): string
    {
        return NewTrackedDomain::class;
    }
}
