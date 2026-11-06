<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\UpdateEntryFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * EntryUpdateRequest
 *
 *
 * @method static \Timatic\Factories\UpdateEntryFactory testFactory()
 */
#[JsonApiType('entries')]
class UpdateEntry extends SpatieData
{
    /** @use HasTestFactory<UpdateEntryFactory> */
    use HasTestFactory;

    public function __construct(
        public ?bool $isPaidPerHour = null,
        public ?int $entrySuggestionId = null,
        public ?string $ticketId = null,
        public ?string $ticketType = null,
        public ?string $ticketTitle = null,
        public ?string $ticketNumber = null,
        public ?int $customerId = null,
        public ?string $customerName = null,
        public ?string $entryType = null,
        public ?int $budgetId = null,
        public ?string $description = null,
        public ?bool $hasOvertime = null,
        public ?bool $hasCustomerOvertime = null,
        public ?bool $isInternal = null,
        public ?Carbon $overtimeStartedAt = null,
        public ?Carbon $overtimeEndedAt = null,
        public ?Carbon $startedAt = null,
        public ?Carbon $endedAt = null,
        public ?bool $isInvoiced = null,
    ) {}
}
