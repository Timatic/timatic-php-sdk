<?php

// auto-generated

namespace Timatic\Dto;

use Timatic\Hydration\Attributes\DateTime;
use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Model;

class Customer extends Model
{
    #[Property]
    public ?string $externalId;

    #[Property]
    public ?string $name;

    #[Property]
    public ?string $hourlyRate;

    #[Property]
    public ?string $accountManagerUserId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;
}
