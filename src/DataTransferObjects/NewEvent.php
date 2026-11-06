<?php

namespace Timatic\DataTransferObjects;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\NewEventFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * EventRequest
 *
 *
 * @method static \Timatic\Factories\NewEventFactory testFactory()
 */
#[JsonApiType('events')]
class NewEvent extends SpatieData
{
    /** @use HasTestFactory<NewEventFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $sourceId = null,
        public ?int $userId = null,
        public ?string $userExternalId = null,
        public ?int $budgetId = null,
        public ?string $ticketId = null,
        public ?string $ticketNumber = null,
        public ?string $ticketType = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?int $customerId = null,
        public ?string $customerExternalId = null,
        public ?string $eventTypeId = null,
        public ?Carbon $startedAt = null,
        public ?Carbon $endedAt = null,
        public ?bool $isInternal = null,
    ) {}
}
