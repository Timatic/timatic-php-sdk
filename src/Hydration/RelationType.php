<?php

declare(strict_types=1);

namespace Timatic\Hydration;

enum RelationType
{
    case Many;
    case One;
}
