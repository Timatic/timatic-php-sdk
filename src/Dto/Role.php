<?php

namespace Timatic\Dto;

use Illuminate\Support\Collection;
use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Attributes\Relationship;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

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
