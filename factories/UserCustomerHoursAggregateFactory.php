<?php

// auto-generated

namespace Timatic\Factories;

use Timatic\Dto\UserCustomerHoursAggregate;

class UserCustomerHoursAggregateFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'customerId' => $this->faker->uuid(),
            'userId' => $this->faker->uuid(),
            'internalMinutes' => $this->faker->numberBetween(15, 480),
            'budgetMinutes' => $this->faker->numberBetween(15, 480),
            'paidPerHourMinutes' => $this->faker->numberBetween(15, 480),
        ];
    }

    protected function modelClass(): string
    {
        return UserCustomerHoursAggregate::class;
    }
}
