<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\DataTransferObjects\UpdateBudget;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<UpdateBudget>
 */
class UpdateBudgetFactory extends Factory
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
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'supervisorUserId' => $this->faker->numberBetween(1, 1000),
            'isArchived' => $this->faker->boolean(),
            'showToCustomer' => $this->faker->boolean(),
            'effectiveFrom' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return UpdateBudget::class;
    }
}
