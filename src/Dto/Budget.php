<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;

class Budget extends Model
{
    #[Property]
    public ?string $budgetTypeId;

    #[Property]
    public ?string $customerId;

    #[Property]
    public ?bool $showToCustomer;

    #[Property]
    public ?string $changeId;

    #[Property]
    public ?string $contractId;

    #[Property]
    public ?string $title;

    #[Property]
    public ?string $description;

    #[Property]
    public ?string $totalPrice;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $startedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $endedAt;

    #[Property]
    public ?int $initialMinutes;

    #[Property]
    public ?bool $isArchived;

    #[Property]
    public ?string $renewalFrequency;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Property]
    public ?string $supervisorUserId;
}
