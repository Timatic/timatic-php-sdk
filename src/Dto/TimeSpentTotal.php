<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\DateTime;
use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Concerns\Model;

class TimeSpentTotal extends Model
{
    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $start;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $end;

    #[Property]
    public ?int $internalMinutes;

    #[Property]
    public ?int $billableMinutes;

    #[Property]
    public ?string $periodUnit;

    #[Property]
    public ?int $periodValue;
}
