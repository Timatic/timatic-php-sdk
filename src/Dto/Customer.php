<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;
use Timatic\SDK\Hydration\Model;

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
