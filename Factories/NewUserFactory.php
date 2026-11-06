<?php

namespace Timatic\Factories;

use Timatic\Dto\NewUser;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<NewUser>
 */
class NewUserFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'externalId' => $this->faker->uuid(),
            'email' => $this->faker->safeEmail(),
            'givenName' => $this->faker->company(),
            'familyName' => $this->faker->company(),
        ];
    }

    protected function modelClass(): string
    {
        return NewUser::class;
    }
}
