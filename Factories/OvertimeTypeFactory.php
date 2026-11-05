<?php

namespace Timatic\Factories;

use Timatic\Dto\OvertimeType;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<OvertimeType>
 */
class OvertimeTypeFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
        ];
    }

    protected function modelClass(): string
    {
        return OvertimeType::class;
    }
}
