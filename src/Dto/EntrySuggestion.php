<?php

namespace Timatic\Dto;

use Illuminate\Support\Collection;
use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Attributes\Relationship;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

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
