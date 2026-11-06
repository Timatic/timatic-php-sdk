<?php

namespace Timatic\DataTransferObjects;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\SuggestionIntegrationFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * SuggestionIntegration
 *
 *
 * @method static \Timatic\Factories\SuggestionIntegrationFactory testFactory()
 */
class SuggestionIntegration extends SpatieData
{
    /** @use HasTestFactory<SuggestionIntegrationFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $label = null,
        public ?string $iconUrl = null,
        public ?string $instructions = null,
        public ?bool $isCompanyManaged = null,
        public ?bool $isActive = null,
        public ?string $connectUrl = null,
        public ?string $connectLabel = null,
    ) {}
}
