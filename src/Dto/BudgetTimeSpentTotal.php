<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;
use Timatic\SDK\Hydration\Model;

class BudgetTimeSpentTotal extends Model
{
    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $start;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $end;

    #[Property]
    public ?int $remainingMinutes;

    #[Property]
    public ?string $periodUnit;

    #[Property]
    public ?int $periodValue;
}
