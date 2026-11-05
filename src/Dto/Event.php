<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\EventFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * Event
 *
 *
 * @method static \Timatic\Factories\EventFactory testFactory()
 */
class Event extends SpatieData
{
    /** @use HasTestFactory<EventFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $userId = null,
        public ?int $budgetId = null,
        public ?string $ticketId = null,
        public ?string $sourceId = null,
        public ?string $ticketNumber = null,
        public ?string $ticketType = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $customerId = null,
        public ?string $eventTypeId = null,
        public ?Carbon $startedAt = null,
        public ?Carbon $endedAt = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        public ?bool $isInternal = null,
        #[JsonApiRelationship(Source::class, RelationType::One)]
        public ?Source $source = null,
    ) {}
}
