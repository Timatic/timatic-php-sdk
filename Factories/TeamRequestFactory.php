<?php

namespace Timatic\Factories;

use Timatic\Dto\TeamRequest;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<TeamRequest>
 */
class TeamRequestFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'externalId' => $this->faker->uuid(),
            'name' => $this->faker->name(),
        ];
    }

    protected function modelClass(): string
    {
        return TeamRequest::class;
    }
}
