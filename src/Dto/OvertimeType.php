<?php

namespace Timatic\Dto;

use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Model;

/**
 * OvertimeType
 */
class OvertimeType extends Model
{
    #[Property]
    public ?string $title;
}
