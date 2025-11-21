<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Concerns\Model;

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
