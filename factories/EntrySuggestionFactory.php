<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\EntrySuggestion;

class EntrySuggestionFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'ticketId' => $this->faker->uuid(),
            'ticketNumber' => $this->faker->word(),
            'customerId' => $this->faker->uuid(),
            'userId' => $this->faker->uuid(),
            'date' => $this->faker->word(),
            'ticketTitle' => $this->faker->sentence(),
            'ticketType' => $this->faker->word(),
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'budgetId' => $this->faker->uuid(),
        ];
    }

    protected function modelClass(): string
    {
        return EntrySuggestion::class;
    }
}
