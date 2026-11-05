<?php

namespace Timatic\Factories;

use Timatic\Dto\Source;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<Source>
 */
class SourceFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'key' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'iconUrl' => $this->faker->word(),
        ];
    }

    protected function modelClass(): string
    {
        return Source::class;
    }
}
