<?php

namespace Timatic\Factories;

use Timatic\Dto\CorrectionUpdateRequest;
use Timatic\Foundation\Factories\Factory;

/**
 * @extends Factory<CorrectionUpdateRequest>
 */
class CorrectionUpdateRequestFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'newEntryId' => $this->faker->numberBetween(1, 1000),
        ];
    }

    protected function modelClass(): string
    {
        return CorrectionUpdateRequest::class;
    }
}
