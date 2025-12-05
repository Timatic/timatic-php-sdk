<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\Budget;

class BudgetFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'budgetTypeId' => $this->faker->uuid(),
            'customerId' => $this->faker->uuid(),
            'showToCustomer' => $this->faker->boolean(),
            'changeId' => $this->faker->uuid(),
            'contractId' => $this->faker->uuid(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'totalPrice' => $this->faker->word(),
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'initialMinutes' => $this->faker->numberBetween(15, 480),
            'isArchived' => $this->faker->boolean(),
            'renewalFrequency' => $this->faker->word(),
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'supervisorUserId' => $this->faker->uuid(),
        ];
    }

    protected function modelClass(): string
    {
        return Budget::class;
    }
}
