<?php

namespace Timatic\Factories;

use Timatic\Dto\CorrectionCreateRequest;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<CorrectionCreateRequest>
 */
class CorrectionCreateRequestFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'correctedEntryId' => $this->faker->numberBetween(1, 1000),
            'newEntryId' => $this->faker->numberBetween(1, 1000),
        ];
    }

    protected function modelClass(): string
    {
        return CorrectionCreateRequest::class;
    }
}
