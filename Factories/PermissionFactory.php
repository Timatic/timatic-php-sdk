<?php

namespace Timatic\Factories;

use Timatic\Dto\Permission;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'values' => (object) [],
        ];
    }

    protected function modelClass(): string
    {
        return Permission::class;
    }
}
