<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\UpdateUser;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<UpdateUser>
 */
class UpdateUserFactory extends Factory
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
        return UpdateUser::class;
    }
}
