<?php

namespace Timatic\Factories;

use Timatic\Dto\Source;
use Timatic\Foundation\Factories\Factory;

class SourceFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'key' => $this->faker->word(),
            'title' => $this->faker->sentence(),
        ];
    }

    protected function modelClass(): string
    {
        return Source::class;
    }
}
