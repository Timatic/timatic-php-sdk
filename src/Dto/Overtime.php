<?php

namespace Timatic\Dto;

use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Attributes\Relationship;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

/**
 * Overtime
 */
class Overtime extends Model
{
    #[Property]
    public ?int $entryId;

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
    public ?int $approvedByUserId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $exportedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Relationship(OvertimeType::class, RelationType::One)]
    public ?OvertimeType $overtimeType = null;

    #[Relationship(Entry::class, RelationType::One)]
    public ?Entry $entry = null;
}
