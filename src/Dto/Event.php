<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;

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
