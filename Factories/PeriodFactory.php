<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\Period;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<Period>
 */
class PeriodFactory extends Factory
{
    protected function definition(): array
    {
        return [
        ];
    }

    protected function modelClass(): string
    {
        return Period::class;
    }
}
