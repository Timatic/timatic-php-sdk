<?php

namespace Timatic\Dto;

use Illuminate\Support\Collection;
use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Attributes\Relationship;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

/**
 * Activity
 */
class Activity extends Model
{
    #[Property]
    public ?string $sourceId;

    #[Property]
    public ?string $eventTypeId;

    #[Property]
    public ?string $customerId;

    #[Property]
    public ?string $ticketId;

    #[Property]
    public ?int $entrySuggestionId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $startedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $endedAt;

    #[Property]
    public ?string $title;

    #[Property]
    public ?string $description;

    #[Property]
    public ?bool $isInternal;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    /** @var Collection<int, Event>|null */
    #[Relationship(Event::class, RelationType::Many)]
    public ?Collection $events = null;
}
