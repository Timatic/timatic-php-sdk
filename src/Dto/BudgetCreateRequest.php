<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\BudgetCreateRequestFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * BudgetCreateRequest
 *
 *
 * @method static \Timatic\Factories\BudgetCreateRequestFactory testFactory()
 */
#[JsonApiType('budgets')]
class BudgetCreateRequest extends SpatieData
{
    /** @use HasTestFactory<BudgetCreateRequestFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $title = null,
        public int|float|null $initialMinutes = null,
        public ?string $changeId = null,
        public ?string $contractId = null,
        public ?string $description = null,
        public int|float|null $totalPrice = null,
        public ?Carbon $startedAt = null,
        public ?Carbon $endedAt = null,
        public ?int $customerId = null,
        public ?bool $showToCustomer = null,
        public ?string $budgetTypeId = null,
        public ?int $supervisorUserId = null,
        public ?string $renewalFrequency = null,
    ) {}
}
