<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;

class Entry extends Model
{
    #[Property]
    public ?string $ticketId;

    #[Property]
    public ?string $ticketNumber;

    #[Property]
    public ?string $ticketTitle;

    #[Property]
    public ?string $ticketType;

    #[Property]
    public ?string $customerId;

    #[Property]
    public ?string $customerName;

    #[Property]
    public ?string $hourlyRate;

    #[Property]
    public ?bool $hadEmergencyShift;

    #[Property]
    public ?string $budgetId;

    #[Property]
    public ?bool $isPaidPerHour;

    #[Property]
    public ?int $minutesSpent;

    #[Property]
    public ?string $userId;

    #[Property]
    public ?string $userEmail;

    #[Property]
    public ?string $userFullName;

    #[Property]
    public ?string $createdByUserId;

    #[Property]
    public ?string $createdByUserEmail;

    #[Property]
    public ?string $createdByUserFullName;

    #[Property]
    public ?string $entryType;

    #[Property]
    public ?string $description;

    #[Property]
    public ?bool $isInternal;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $startedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $endedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $invoicedAt;

    #[Property]
    public ?string $isInvoiced;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Property]
    public ?bool $isBasedOnSuggestion;
}
