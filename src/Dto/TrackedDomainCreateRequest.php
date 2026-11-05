<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\TrackedDomainCreateRequestFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * TrackedDomainCreateRequest
 *
 *
 * @method static \Timatic\Factories\TrackedDomainCreateRequestFactory testFactory()
 */
#[JsonApiType('tracked-domains')]
class TrackedDomainCreateRequest extends SpatieData
{
    /** @use HasTestFactory<TrackedDomainCreateRequestFactory> */
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
