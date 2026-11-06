<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\UpdateUserFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * UserRequest
 *
 *
 * @method static \Timatic\Factories\UpdateUserFactory testFactory()
 */
#[JsonApiType('users')]
class UpdateUser extends SpatieData
{
    /** @use HasTestFactory<UpdateUserFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $externalId = null,
        public ?string $email = null,
        public ?string $givenName = null,
        public ?string $familyName = null,
        #[JsonApiRelationship(Team::class, RelationType::One)]
        public ?Team $team = null,
    ) {}
}
