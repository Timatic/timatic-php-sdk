<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\ExportFormat;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<ExportFormat>
 */
class ExportFormatFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'periodOptions' => $this->faker->word(),
            'extension' => $this->faker->word(),
        ];
    }

    protected function modelClass(): string
    {
        return ExportFormat::class;
    }
}
