<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\PermissionFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * Permission
 *
 *
 * @method static \Timatic\Factories\PermissionFactory testFactory()
 */
class Permission extends SpatieData
{
    /** @use HasTestFactory<PermissionFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?object $values = null,
    ) {}
}
