<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\UpdateCustomer;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<UpdateCustomer>
 */
class UpdateCustomerFactory extends Factory
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
        return UpdateCustomer::class;
    }
}
