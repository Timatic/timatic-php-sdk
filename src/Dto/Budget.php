<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\BudgetFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * Budget
 *
 *
 * @method static \Timatic\Factories\BudgetFactory testFactory()
 */
class Budget extends SpatieData
{
    /** @use HasTestFactory<BudgetFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $budgetTypeId = null,
        public ?string $customerId = null,
        public ?bool $showToCustomer = null,
        public ?string $changeId = null,
        public ?string $contractId = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $totalPrice = null,
        public ?Carbon $startedAt = null,
        public ?Carbon $endedAt = null,
        public ?int $initialMinutes = null,
        public ?bool $isArchived = null,
        public ?string $renewalFrequency = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        /** @var Collection<int, Entry>|null */
        #[JsonApiRelationship(Entry::class, RelationType::Many)]
        public ?Collection $entries = null,
        #[JsonApiRelationship(BudgetType::class, RelationType::One)]
        public ?BudgetType $budgetType = null,
        #[JsonApiRelationship(Customer::class, RelationType::One)]
        public ?Customer $customer = null,
        #[JsonApiRelationship(User::class, RelationType::One)]
        public ?User $supervisor = null,
    ) {}
}
