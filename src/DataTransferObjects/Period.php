<?php

namespace Timatic\DataTransferObjects;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\PeriodFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * Period
 *
 *
 * @method static \Timatic\Factories\PeriodFactory testFactory()
 */
#[JsonApiType('periods')]
class Period extends SpatieData
{
    /** @use HasTestFactory<PeriodFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
    ) {}
}
