<?php

namespace Timatic\Factories;

use Timatic\DataTransferObjects\ProjectMapping;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<ProjectMapping>
 */
class ProjectMappingFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'projectKey' => $this->faker->word(),
            'projectName' => $this->faker->company(),
            'customerId' => null,
            'budgetId' => null,
            'isArchived' => $this->faker->boolean(),
        ];
    }

    protected function modelClass(): string
    {
        return ProjectMapping::class;
    }
}
