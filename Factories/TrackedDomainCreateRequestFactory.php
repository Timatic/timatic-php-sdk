<?php

namespace Timatic\Factories;

use Timatic\Dto\TrackedDomainCreateRequest;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<TrackedDomainCreateRequest>
 */
class TrackedDomainCreateRequestFactory extends Factory
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
        return TrackedDomainCreateRequest::class;
    }
}
