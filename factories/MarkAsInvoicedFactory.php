<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\MarkAsInvoiced;

class MarkAsInvoicedFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'ticketId' => $this->faker->uuid(),
            'ticketNumber' => $this->faker->word(),
            'ticketTitle' => $this->faker->sentence(),
            'ticketType' => $this->faker->word(),
            'customerId' => $this->faker->uuid(),
            'customerName' => $this->faker->company(),
            'hourlyRate' => number_format($this->faker->randomFloat(2, 50, 150), 2, '.', ''),
            'hadEmergencyShift' => $this->faker->boolean(),
            'budgetId' => $this->faker->uuid(),
            'isPaidPerHour' => $this->faker->boolean(),
            'minutesSpent' => $this->faker->numberBetween(15, 480),
            'userId' => $this->faker->uuid(),
            'userEmail' => $this->faker->safeEmail(),
            'userFullName' => $this->faker->name(),
            'createdByUserId' => $this->faker->uuid(),
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
        return MarkAsInvoiced::class;
    }
}
