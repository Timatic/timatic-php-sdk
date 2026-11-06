<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\UpdateTeam;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<UpdateTeam>
 */
class UpdateTeamFactory extends Factory
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
        return UpdateTeam::class;
    }
}
