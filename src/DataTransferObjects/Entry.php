<?php

namespace Timatic\DataTransferObjects;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\EntryFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * Entry
 *
 *
 * @method static \Timatic\Factories\EntryFactory testFactory()
 */
#[JsonApiType('entries')]
class Entry extends SpatieData
{
    /** @use HasTestFactory<EntryFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $ticketId = null,
        public ?string $ticketNumber = null,
        public ?string $ticketTitle = null,
        public ?string $ticketType = null,
        public ?string $customerId = null,
        public ?string $customerName = null,
        public int|float|null $hourlyRate = null,
        public ?bool $hadEmergencyShift = null,
        public ?int $budgetId = null,
        public ?string $isPaidPerHour = null,
        public ?int $minutesSpent = null,
        public ?string $userId = null,
        public ?string $userEmail = null,
        public ?string $userFullName = null,
        public ?int $createdByUserId = null,
        public ?string $createdByUserEmail = null,
        public ?string $createdByUserFullName = null,
        public ?string $entryType = null,
        public ?string $description = null,
        public ?bool $isInternal = null,
        public ?Carbon $startedAt = null,
        public ?Carbon $endedAt = null,
        public ?Carbon $invoicedAt = null,
        public ?bool $isInvoiced = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        public ?bool $isBasedOnSuggestion = null,
        #[JsonApiRelationship(Overtime::class, RelationType::One)]
        public ?Overtime $personalOvertime = null,
        #[JsonApiRelationship(Overtime::class, RelationType::One)]
        public ?Overtime $customerOvertime = null,
        #[JsonApiRelationship(Correction::class, RelationType::One)]
        public ?Correction $correctionEntryCorrection = null,
        #[JsonApiRelationship(Correction::class, RelationType::One)]
        public ?Correction $correctedEntryCorrection = null,
        #[JsonApiRelationship(Correction::class, RelationType::One)]
        public ?Correction $newEntryCorrection = null,
        #[JsonApiRelationship(Customer::class, RelationType::One)]
        public ?Customer $customer = null,
        #[JsonApiRelationship(Budget::class, RelationType::One)]
        public ?Budget $budget = null,
    ) {}
}
