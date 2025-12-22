<?php

// auto-generated

namespace Timatic\Dto;

use Timatic\Hydration\Attributes\DateTime;
use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Attributes\Relationship;
use Timatic\Hydration\Model;
use Timatic\Hydration\RelationType;

/**
 * Entry
 */
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
    public ?int $customerId;

    #[Property]
    public ?string $customerName;

    #[Property]
    public ?float $hourlyRate;

    #[Property]
    public ?bool $hadEmergencyShift;

    #[Property]
    public ?int $budgetId;

    #[Property]
    public ?string $isPaidPerHour;

    #[Property]
    public ?int $minutesSpent;

    #[Property]
    public ?int $userId;

    #[Property]
    public ?string $userEmail;

    #[Property]
    public ?string $userFullName;

    #[Property]
    public ?int $createdByUserId;

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

    #[Relationship(Overtime::class, RelationType::One)]
    public ?Overtime $personalOvertime = null;

    #[Relationship(Overtime::class, RelationType::One)]
    public ?Overtime $customerOvertime = null;

    #[Relationship(Correction::class, RelationType::One)]
    public ?Correction $correctionEntryCorrection = null;

    #[Relationship(Correction::class, RelationType::One)]
    public ?Correction $correctedEntryCorrection = null;

    #[Relationship(Correction::class, RelationType::One)]
    public ?Correction $newEntryCorrection = null;

    #[Relationship(Customer::class, RelationType::One)]
    public ?Customer $customer = null;

    #[Relationship(Budget::class, RelationType::One)]
    public ?Budget $budget = null;
}
