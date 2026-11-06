<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\UpdateCorrection;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<UpdateCorrection>
 */
class UpdateCorrectionFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'newEntryId' => $this->faker->numberBetween(1, 1000),
        ];
    }

    protected function modelClass(): string
    {
        return UpdateCorrection::class;
    }
}
