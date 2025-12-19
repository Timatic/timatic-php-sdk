<?php

// auto-generated

namespace Timatic\Factories;

use Timatic\Dto\User;

class UserFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'externalId' => $this->faker->uuid(),
            'email' => $this->faker->safeEmail(),
            'givenName' => $this->faker->company(),
            'familyName' => $this->faker->company(),
            'teamId' => $this->faker->uuid(),
        ];
    }

    protected function modelClass(): string
    {
        return User::class;
    }
}
