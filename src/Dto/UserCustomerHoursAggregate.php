<?php

// auto-generated

namespace Timatic\Dto;

use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Attributes\Relationship;
use Timatic\Hydration\Model;
use Timatic\Hydration\RelationType;

class UserCustomerHoursAggregate extends Model
{
    #[Property]
    public ?string $customerId;

    #[Property]
    public ?string $userId;

    #[Property]
    public ?int $internalMinutes;

    #[Property]
    public ?int $budgetMinutes;

    #[Property]
    public ?int $paidPerHourMinutes;

    #[Relationship(Customer::class, RelationType::One)]
    public ?Customer $customer = null;

    #[Relationship(User::class, RelationType::One)]
    public ?User $user = null;
}
