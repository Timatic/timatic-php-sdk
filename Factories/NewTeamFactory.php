<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\NewTeam;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<NewTeam>
 */
class NewTeamFactory extends Factory
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
        return NewTeam::class;
    }
}
