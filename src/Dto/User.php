<?php

// auto-generated

namespace Timatic\Dto;

use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Model;

class User extends Model
{
    #[Property]
    public ?string $externalId;

    #[Property]
    public ?string $email;
}
