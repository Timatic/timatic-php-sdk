<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\OvertimeTypeFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * OvertimeType
 *
 *
 * @method static \Timatic\Factories\OvertimeTypeFactory testFactory()
 */
class OvertimeType extends SpatieData
{
    /** @use HasTestFactory<OvertimeTypeFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
    ) {}
}
