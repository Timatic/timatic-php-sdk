<?php

namespace Timatic\Dto;

use Illuminate\Support\Collection;
use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Attributes\Relationship;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

/**
 * User
 */
class User extends Model
{
    #[Property]
    public ?string $externalId;

    #[Property]
    public ?string $email;

    #[Property]
    public ?string $givenName;

    #[Property]
    public ?string $familyName;

    #[Property]
    public ?bool $isImpersonated;

    #[Property]
    public ?int $impersonatedById;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    /** @var Collection<int, Role>|null */
    #[Relationship(Role::class, RelationType::Many)]
    public ?Collection $roles = null;

    /** @var Collection<int, Permission>|null */
    #[Relationship(Permission::class, RelationType::Many)]
    public ?Collection $permissions = null;

    #[Relationship(Team::class, RelationType::One)]
    public ?Team $team = null;
}
