<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Hydration\Attributes\DateTime;
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
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Property]
    public ?string $budgetId;
}
