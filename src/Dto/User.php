<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Hydration\Attributes\Property;

class User extends Model
{
    #[Property]
    public ?string $externalId;

    #[Property]
    public ?string $email;
}
