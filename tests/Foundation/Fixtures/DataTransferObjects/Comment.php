<?php

declare(strict_types=1);

namespace Timatic\Tests\Foundation\Fixtures\DataTransferObjects;

use Spatie\LaravelData\Data;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;

#[JsonApiType('comments')]
class Comment extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $body = null,
    ) {}
}
