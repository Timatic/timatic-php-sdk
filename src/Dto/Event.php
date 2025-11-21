<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Concerns\Model;

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
    public ?string $startedAt;

    #[Property]
    public ?string $endedAt;

    #[Property]
    public ?string $createdAt;

    #[Property]
    public ?string $updatedAt;

    #[Property]
    public ?string $isInternal;
}
