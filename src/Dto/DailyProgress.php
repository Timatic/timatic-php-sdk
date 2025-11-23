<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;
use Timatic\SDK\Hydration\Model;

class DailyProgress extends Model
{
    #[Property]
    public ?string $userId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $date;

    #[Property]
    public ?string $progress;
}
