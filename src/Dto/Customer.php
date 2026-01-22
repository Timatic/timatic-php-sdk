<?php

namespace Timatic\Dto;

use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Attributes\Relationship;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

/**
 * Customer
 */
class Customer extends Model
{
    #[Property]
    public ?string $externalId;

    #[Property]
    public ?string $name;

    #[Property]
    public ?string $hourlyRate;

    #[Property]
    public ?int $accountManagerUserId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Relationship(User::class, RelationType::One)]
    public ?User $accountManager = null;
}
