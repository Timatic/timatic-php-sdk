<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\BudgetCreateRequest;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<BudgetCreateRequest>
 */
class BudgetCreateRequestFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'initialMinutes' => null,
            'changeId' => $this->faker->uuid(),
            'contractId' => $this->faker->uuid(),
            'description' => $this->faker->sentence(),
            'totalPrice' => null,
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'customerId' => $this->faker->numberBetween(1, 1000),
            'showToCustomer' => $this->faker->boolean(),
            'budgetTypeId' => $this->faker->uuid(),
            'supervisorUserId' => $this->faker->numberBetween(1, 1000),
            'renewalFrequency' => $this->faker->word(),
        ];
    }

    protected function modelClass(): string
    {
        return BudgetCreateRequest::class;
    }
}
