<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\NewTrackedDomainFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * TrackedDomainCreateRequest
 *
 *
 * @method static \Timatic\Factories\NewTrackedDomainFactory testFactory()
 */
#[JsonApiType('tracked-domains')]
class NewTrackedDomain extends SpatieData
{
    /** @use HasTestFactory<NewTrackedDomainFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $domain = null,
        public ?string $path = null,
        public ?int $customerId = null,
        public ?int $budgetId = null,
        public ?bool $isInternal = null,
        public ?int $userId = null,
        public ?int $parentId = null,
    ) {}
}
