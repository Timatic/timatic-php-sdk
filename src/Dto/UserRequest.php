<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\UserRequestFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * UserRequest
 *
 *
 * @method static \Timatic\Factories\UserRequestFactory testFactory()
 */
#[JsonApiType('users')]
class UserRequest extends SpatieData
{
    /** @use HasTestFactory<UserRequestFactory> */
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
