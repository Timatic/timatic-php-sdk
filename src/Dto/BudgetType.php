<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Hydration\Attributes\Property;

class BudgetType extends Model
{
    #[Property]
    public ?string $title;

    #[Property]
    public ?bool $isArchived;

    #[Property]
    public ?bool $hasChangeTicket;

    #[Property]
    public ?string $renewalFrequencies;

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
