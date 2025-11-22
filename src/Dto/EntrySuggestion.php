<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Hydration\Attributes\Property;

class EntrySuggestion extends Model
{
    #[Property]
    public ?string $ticketId;

    #[Property]
    public ?string $ticketNumber;

    #[Property]
    public ?string $customerId;

    #[Property]
    public ?string $userId;

    #[Property]
    public ?string $date;

    #[Property]
    public ?string $ticketTitle;

    #[Property]
    public ?string $ticketType;

    #[Property]
    public ?string $createdAt;

    #[Property]
    public ?string $updatedAt;

    #[Property]
    public ?string $budgetId;
}
