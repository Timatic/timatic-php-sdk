<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Concerns\Model;

class User extends Model
{
    #[Property]
    public ?string $externalId;

    #[Property]
    public ?string $email;
}
