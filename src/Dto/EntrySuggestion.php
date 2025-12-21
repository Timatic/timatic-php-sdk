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
 * EntrySuggestion
 */
class EntrySuggestion extends Model
{
    #[Property]
    public ?string $ticketId;

    #[Property]
    public ?string $ticketNumber;

    #[Property]
    public ?string $customerId;

    #[Property]
    public ?int $userId;

    #[Property]
    public ?string $date;

    #[Property]
    public ?string $ticketTitle;

    #[Property]
    public ?string $ticketType;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Property]
    public ?int $budgetId;

    /** @var Collection<int, Activity>|null */
    #[Relationship(Activity::class, RelationType::Many)]
    public ?Collection $activities = null;
}
