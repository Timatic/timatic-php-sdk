<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\Entry;

class EntryFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'ticketId' => $this->faker->uuid(),
            'ticketNumber' => $this->faker->word(),
            'ticketTitle' => $this->faker->sentence(),
            'ticketType' => $this->faker->word(),
            'customerId' => $this->faker->numberBetween(1, 1000),
            'customerName' => $this->faker->company(),
            'hourlyRate' => $this->faker->randomFloat(2, 0, 1000),
            'hadEmergencyShift' => $this->faker->boolean(),
            'budgetId' => $this->faker->numberBetween(1, 1000),
            'isPaidPerHour' => $this->faker->word(),
            'minutesSpent' => $this->faker->numberBetween(15, 480),
            'userId' => $this->faker->numberBetween(1, 1000),
            'userEmail' => $this->faker->safeEmail(),
            'userFullName' => $this->faker->name(),
            'createdByUserId' => $this->faker->numberBetween(1, 1000),
            'createdByUserEmail' => $this->faker->safeEmail(),
            'createdByUserFullName' => $this->faker->company(),
            'entryType' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'isInternal' => $this->faker->boolean(),
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'invoicedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'isInvoiced' => $this->faker->word(),
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'isBasedOnSuggestion' => $this->faker->boolean(),
        ];
    }

    protected function modelClass(): string
    {
        return Entry::class;
    }
}
