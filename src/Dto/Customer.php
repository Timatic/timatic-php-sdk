<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\CustomerFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * Customer
 *
 *
 * @method static \Timatic\Factories\CustomerFactory testFactory()
 */
#[JsonApiType('customers')]
class Customer extends SpatieData
{
    /** @use HasTestFactory<CustomerFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $externalId = null,
        public ?string $name = null,
        public ?string $hourlyRate = null,
        public ?bool $isOwnOrganization = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        #[JsonApiRelationship(User::class, RelationType::One)]
        public ?User $accountManager = null,
    ) {}
}
