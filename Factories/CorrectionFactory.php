<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\Correction;
use Timatic\Foundation\Factories\Factory;

class CorrectionFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return Correction::class;
    }
}
