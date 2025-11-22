<?php

declare(strict_types=1);

namespace Timatic\SDK\Hydration\Attributes;

use Attribute;
use Timatic\SDK\Hydration\Model;
use Timatic\SDK\Hydration\RelationType;

#[Attribute]
readonly class Relationship
{
    /**
     * @param  class-string<Model>  $model
     */
    public function __construct(public string $model, public RelationType $type) {}
}
