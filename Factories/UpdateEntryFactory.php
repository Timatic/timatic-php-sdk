<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\UpdateEntry;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<UpdateEntry>
 */
class UpdateEntryFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'isPaidPerHour' => $this->faker->boolean(),
            'entrySuggestionId' => $this->faker->numberBetween(1, 1000),
            'ticketId' => $this->faker->uuid(),
            'ticketType' => $this->faker->word(),
            'ticketTitle' => $this->faker->sentence(),
            'ticketNumber' => $this->faker->word(),
            'customerId' => $this->faker->numberBetween(1, 1000),
            'customerName' => $this->faker->company(),
            'entryType' => $this->faker->word(),
            'budgetId' => $this->faker->numberBetween(1, 1000),
            'description' => $this->faker->sentence(),
            'hasOvertime' => $this->faker->boolean(),
            'hasCustomerOvertime' => $this->faker->boolean(),
            'isInternal' => $this->faker->boolean(),
            'overtimeStartedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'overtimeEndedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'startedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'endedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'isInvoiced' => $this->faker->boolean(),
        ];
    }

    protected function modelClass(): string
    {
        return UpdateEntry::class;
    }
}
