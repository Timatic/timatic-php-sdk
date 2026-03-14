<?php

namespace Timatic\Factories;

use Timatic\Dto\Permission;
use Timatic\Foundation\Factories\Factory;

class PermissionFactory extends Factory
{
    protected function definition(): array
    {
        return [
        ];
    }

    protected function modelClass(): string
    {
        return Permission::class;
    }
}
