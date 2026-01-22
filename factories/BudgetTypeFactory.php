<?php

namespace Timatic\Factories;

use Timatic\Dto\BudgetType;
use Timatic\Foundation\Factories\Factory;

class BudgetTypeFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'isArchived' => $this->faker->boolean(),
            'hasChangeTicket' => $this->faker->boolean(),
            'renewalFrequencies' => [],
            'hasSupervisor' => $this->faker->boolean(),
            'hasContractId' => $this->faker->boolean(),
            'hasTotalPrice' => $this->faker->boolean(),
            'ticketIsRequired' => $this->faker->boolean(),
            'defaultTitle' => $this->faker->sentence(),
        ];
    }

    protected function modelClass(): string
    {
        return BudgetType::class;
    }
}
