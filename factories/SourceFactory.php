<?php

// auto-generated

namespace Timatic\Factories;

use Timatic\Dto\Source;

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
