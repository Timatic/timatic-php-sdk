<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\UpdateBudgetFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * BudgetUpdateRequest
 *
 *
 * @method static \Timatic\Factories\UpdateBudgetFactory testFactory()
 */
#[JsonApiType('budgets')]
class UpdateBudget extends SpatieData
{
    /** @use HasTestFactory<UpdateBudgetFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $title = null,
        public int|float|null $initialMinutes = null,
        public ?string $changeId = null,
        public ?string $contractId = null,
        public ?string $description = null,
        public int|float|null $totalPrice = null,
        public ?Carbon $endedAt = null,
        public ?int $supervisorUserId = null,
        public ?bool $isArchived = null,
        public ?bool $showToCustomer = null,
        public ?Carbon $effectiveFrom = null,
    ) {}
}
