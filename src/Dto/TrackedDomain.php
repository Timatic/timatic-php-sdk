<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\TrackedDomainFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * TrackedDomain
 *
 *
 * @method static \Timatic\Factories\TrackedDomainFactory testFactory()
 */
class TrackedDomain extends SpatieData
{
    /** @use HasTestFactory<TrackedDomainFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $domain = null,
        public ?string $path = null,
        public ?int $customerId = null,
        public ?int $budgetId = null,
        public ?bool $isInternal = null,
        public ?int $userId = null,
        public ?int $parentId = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        #[JsonApiRelationship(Customer::class, RelationType::One)]
        public ?Customer $customer = null,
        #[JsonApiRelationship(Budget::class, RelationType::One)]
        public ?Budget $budget = null,
    ) {}
}
