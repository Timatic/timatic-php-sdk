<?php

declare(strict_types=1);

namespace Timatic\Hydration;

interface ModelInterface
{
    public function type(): string;

    public function fill(array $attributes): void;

    public function attributes(): array;
}
