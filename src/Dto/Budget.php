<?php

// auto-generated

namespace Timatic\Dto;

use Illuminate\Support\Collection;
use Timatic\Hydration\Attributes\DateTime;
use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Attributes\Relationship;
use Timatic\Hydration\Model;
use Timatic\Hydration\RelationType;

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

    /** @var Collection<int, Entry>|null */
    #[Relationship(Entry::class, RelationType::Many)]
    public ?Collection $entries = null;

    #[Relationship(BudgetType::class, RelationType::One)]
    public ?BudgetType $budgetType = null;

    #[Relationship(Customer::class, RelationType::One)]
    public ?Customer $customer = null;
}
