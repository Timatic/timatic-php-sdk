<?php

namespace Timatic\Factories;

use Timatic\Dto\CustomerRequest;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<CustomerRequest>
 */
class CustomerRequestFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'externalId' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'isOwnOrganization' => $this->faker->boolean(),
        ];
    }

    protected function modelClass(): string
    {
        return CustomerRequest::class;
    }
}
