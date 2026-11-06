<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\NewCustomer;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<NewCustomer>
 */
class NewCustomerFactory extends Factory
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
        return NewCustomer::class;
    }
}
