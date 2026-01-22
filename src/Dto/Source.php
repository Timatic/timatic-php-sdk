<?php

namespace Timatic\Dto;

use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Model;

/**
 * Source
 */
class Source extends Model
{
    #[Property]
    public ?string $key;

    #[Property]
    public ?string $title;
}
