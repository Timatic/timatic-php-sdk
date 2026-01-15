<?php

// auto-generated

namespace Timatic\Dto;

use Illuminate\Support\Collection;
use Timatic\Hydration\Attributes\DateTime;
use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Attributes\Relationship;
use Timatic\Hydration\Model;
use Timatic\Hydration\RelationType;

/**
 * Role
 */
class Role extends Model
{
    #[Property]
    public ?string $name;

    #[Property]
    public ?string $guardName;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    /** @var Collection<int, Permission>|null */
    #[Relationship(Permission::class, RelationType::Many)]
    public ?Collection $permissions = null;
}
