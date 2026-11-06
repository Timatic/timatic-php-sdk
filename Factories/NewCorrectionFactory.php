<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\NewCorrection;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<NewCorrection>
 */
class NewCorrectionFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'correctedEntryId' => $this->faker->numberBetween(1, 1000),
            'newEntryId' => $this->faker->numberBetween(1, 1000),
        ];
    }

    protected function modelClass(): string
    {
        return NewCorrection::class;
    }
}
