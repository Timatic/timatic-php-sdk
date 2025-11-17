<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Foundation\Model;

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
