<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\EntrySuggestion;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<EntrySuggestion>
 */
class EntrySuggestionFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'ticketId' => $this->faker->uuid(),
            'ticketNumber' => $this->faker->word(),
            'customerId' => $this->faker->uuid(),
            'userId' => $this->faker->uuid(),
            'date' => null,
            'ticketTitle' => $this->faker->sentence(),
            'ticketType' => null,
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'budgetId' => null,
        ];
    }

    protected function modelClass(): string
    {
        return EntrySuggestion::class;
    }
}
