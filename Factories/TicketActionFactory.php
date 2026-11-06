<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\TicketAction;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<TicketAction>
 */
class TicketActionFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'entryDate' => null,
            'text' => $this->faker->word(),
            'personDisplayName' => $this->faker->company(),
            'personEmail' => $this->faker->safeEmail(),
        ];
    }

    protected function modelClass(): string
    {
        return TicketAction::class;
    }
}
