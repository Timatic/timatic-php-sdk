<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Foundation\Model;

class MarkAsInvoiced extends Model
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
    public ?string $startedAt;

    #[Property]
    public ?string $endedAt;

    #[Property]
    public ?string $invoicedAt;

    #[Property]
    public ?string $isInvoiced;

    #[Property]
    public ?string $createdAt;

    #[Property]
    public ?string $updatedAt;

    #[Property]
    public ?bool $isBasedOnSuggestion;
}
