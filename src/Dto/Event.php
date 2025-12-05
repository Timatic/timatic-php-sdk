<?php

// auto-generated

namespace Timatic\Dto;

use Timatic\Hydration\Attributes\DateTime;
use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Model;

class Event extends Model
{
    #[Property]
    public ?string $userId;

    #[Property]
    public ?string $budgetId;

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
    public ?string $isInternal;
}
