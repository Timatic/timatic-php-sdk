<?php

namespace Timatic\Dto;

use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Model;

/**
 * BudgetType
 */
class BudgetType extends Model
{
    #[Property]
    public ?string $title;

    #[Property]
    public ?bool $isArchived;

    #[Property]
    public ?bool $hasChangeTicket;

    #[Property]
    public ?array $renewalFrequencies;

    #[Property]
    public ?bool $hasSupervisor;

    #[Property]
    public ?bool $hasContractId;

    #[Property]
    public ?bool $hasTotalPrice;

    #[Property]
    public ?bool $ticketIsRequired;

    #[Property]
    public ?string $defaultTitle;
}
