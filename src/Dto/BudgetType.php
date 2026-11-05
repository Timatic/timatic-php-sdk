<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\BudgetTypeFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * BudgetType
 *
 *
 * @method static \Timatic\Factories\BudgetTypeFactory testFactory()
 */
class BudgetType extends SpatieData
{
    /** @use HasTestFactory<BudgetTypeFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?bool $isArchived = null,
        public ?bool $hasChangeTicket = null,
        public ?array $renewalFrequencies = null,
        public ?bool $hasSupervisor = null,
        public ?bool $hasContractId = null,
        public ?bool $hasTotalPrice = null,
        public ?bool $ticketIsRequired = null,
        public ?string $defaultTitle = null,
    ) {}
}
