<?php

// auto-generated

namespace Timatic\Dto;

use Timatic\Hydration\Attributes\DateTime;
use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Attributes\Relationship;
use Timatic\Hydration\Model;
use Timatic\Hydration\RelationType;

class Overtime extends Model
{
    #[Property]
    public ?string $entryId;

    #[Property]
    public ?string $overtimeTypeId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $startedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $endedAt;

    #[Property]
    public ?string $percentages;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $approvedAt;

    #[Property]
    public ?string $approvedByUserId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $exportedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Relationship(Entry::class, RelationType::One)]
    public ?Entry $entry = null;
}
