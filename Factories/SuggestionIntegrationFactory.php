<?php

namespace Timatic\Factories;

use Timatic\Dto\SuggestionIntegration;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<SuggestionIntegration>
 */
class SuggestionIntegrationFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'iconUrl' => $this->faker->word(),
            'instructions' => $this->faker->word(),
            'isCompanyManaged' => $this->faker->boolean(),
            'isActive' => $this->faker->boolean(),
            'connectUrl' => null,
            'connectLabel' => null,
        ];
    }

    protected function modelClass(): string
    {
        return SuggestionIntegration::class;
    }
}
