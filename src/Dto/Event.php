<?php

namespace Timatic\Dto;

use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Attributes\Relationship;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

/**
 * Event
 */
class Event extends Model
{
    #[Property]
    public ?int $userId;

    #[Property]
    public ?int $budgetId;

    #[Property]
    public ?string $ticketId;

    #[Property]
    public ?string $sourceId;

    #[Property]
    public ?string $ticketNumber;

    #[Property]
    public ?string $ticketType;

    #[Property]
    public ?string $title;

    #[Property]
    public ?string $description;

    #[Property]
    public ?string $customerId;

    #[Property]
    public ?string $eventTypeId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $startedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $endedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Property]
    public ?bool $isInternal;

    #[Relationship(Source::class, RelationType::One)]
    public ?Source $source = null;
}
