<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\UserFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * User
 *
 *
 * @method static \Timatic\Factories\UserFactory testFactory()
 */
class User extends SpatieData
{
    /** @use HasTestFactory<UserFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $externalId = null,
        public ?string $email = null,
        public ?string $givenName = null,
        public ?string $familyName = null,
        public ?bool $isImpersonated = null,
        public ?int $impersonatedById = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        /** @var Collection<int, Permission>|null */
        #[JsonApiRelationship(Permission::class, RelationType::Many)]
        public ?Collection $permissions = null,
        #[JsonApiRelationship(Team::class, RelationType::One)]
        public ?Team $team = null,
    ) {}
}
