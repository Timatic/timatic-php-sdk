<?php

namespace Timatic\Dto;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\TicketFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * Ticket
 *
 *
 * @method static \Timatic\Factories\TicketFactory testFactory()
 */
class Ticket extends SpatieData
{
    /** @use HasTestFactory<TicketFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $key = null,
        public ?string $title = null,
        public ?string $createdAt = null,
        public ?string $closedAt = null,
        public ?string $url = null,
        public ?int $customerId = null,
        public ?int $budgetId = null,
        /** @var Collection<int, Customer>|null */
        #[JsonApiRelationship(Customer::class, RelationType::Many)]
        public ?Collection $customers = null,
    ) {}
}
