<?php

declare(strict_types=1);

namespace Timatic\SDK\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Property
{
    public function __construct(
        public bool $isReadOnly = false
    ) {}
}
