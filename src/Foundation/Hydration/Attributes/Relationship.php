<?php

declare(strict_types=1);

namespace Timatic\Foundation\Hydration\Attributes;

use Attribute;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

#[Attribute]
readonly class Relationship
{
    /**
     * @param  class-string<Model>  $model
     */
    public function __construct(public string $model, public RelationType $type) {}
}
