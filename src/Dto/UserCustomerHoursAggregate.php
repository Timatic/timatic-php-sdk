<?php

// auto-generated

namespace Timatic\Dto;

use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Model;

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
}
