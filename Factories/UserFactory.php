<?php

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\User;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'externalId' => $this->faker->uuid(),
            'email' => $this->faker->safeEmail(),
            'givenName' => $this->faker->company(),
            'familyName' => $this->faker->company(),
            'isImpersonated' => $this->faker->boolean(),
            'impersonatedById' => null,
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return User::class;
    }
}
