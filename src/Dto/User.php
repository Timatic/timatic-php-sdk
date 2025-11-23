<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Hydration\Attributes\Property;
use Timatic\SDK\Hydration\Model;

class User extends Model
{
    #[Property]
    public ?string $externalId;

    #[Property]
    public ?string $email;
}
