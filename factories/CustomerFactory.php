<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\Customer;
use Timatic\Foundation\Factories\Factory;

class CustomerFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'externalId' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'hourlyRate' => number_format($this->faker->randomFloat(2, 50, 150), 2, '.', ''),
            'accountManagerUserId' => $this->faker->word(),
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return Customer::class;
    }
}
