<?php

namespace Timatic\Dto;

use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Model;

/**
 * Team
 */
class Team extends Model
{
    #[Property]
    public ?string $externalId;

    #[Property]
    public ?string $name;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;
}
