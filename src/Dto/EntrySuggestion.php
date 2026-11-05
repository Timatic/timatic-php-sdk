<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\EntrySuggestionFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * EntrySuggestion
 *
 *
 * @method static \Timatic\Factories\EntrySuggestionFactory testFactory()
 */
#[JsonApiType('entrySuggestions')]
class EntrySuggestion extends SpatieData
{
    /** @use HasTestFactory<EntrySuggestionFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $ticketId = null,
        public ?string $ticketNumber = null,
        public ?string $customerId = null,
        public ?string $userId = null,
        public ?string $date = null,
        public ?string $ticketTitle = null,
        public ?string $ticketType = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        public ?int $budgetId = null,
        /** @var Collection<int, Activity>|null */
        #[JsonApiRelationship(Activity::class, RelationType::Many)]
        public ?Collection $activities = null,
    ) {}
}
