<?php

// auto-generated

namespace Timatic\Factories;

use Timatic\Dto\BudgetType;

class BudgetTypeFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'isArchived' => $this->faker->boolean(),
            'hasChangeTicket' => $this->faker->boolean(),
            'renewalFrequencies' => $this->faker->word(),
            'hasSupervisor' => $this->faker->boolean(),
            'hasContractId' => $this->faker->uuid(),
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
