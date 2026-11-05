<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\ActivityFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * Activity
 *
 *
 * @method static \Timatic\Factories\ActivityFactory testFactory()
 */
class Activity extends SpatieData
{
    /** @use HasTestFactory<ActivityFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $sourceId = null,
        public ?string $eventTypeId = null,
        public ?string $customerId = null,
        public ?string $ticketId = null,
        public ?int $entrySuggestionId = null,
        public ?Carbon $startedAt = null,
        public ?Carbon $endedAt = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?bool $isInternal = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        /** @var Collection<int, Event>|null */
        #[JsonApiRelationship(Event::class, RelationType::Many)]
        public ?Collection $events = null,
    ) {}
}
