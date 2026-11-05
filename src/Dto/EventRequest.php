<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\EventRequestFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * EventRequest
 *
 *
 * @method static \Timatic\Factories\EventRequestFactory testFactory()
 */
#[JsonApiType('events')]
class EventRequest extends SpatieData
{
    /** @use HasTestFactory<EventRequestFactory> */
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
