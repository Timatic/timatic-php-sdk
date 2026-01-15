<?php

// auto-generated

namespace Timatic\Factories;

use Carbon\Carbon;
use Timatic\Dto\Role;

class RoleFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'guardName' => $this->faker->company(),
            'createdAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
            'updatedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return Role::class;
    }
}
