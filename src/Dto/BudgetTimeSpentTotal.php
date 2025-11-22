<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;

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
