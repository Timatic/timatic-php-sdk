<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\PeriodFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * Period
 *
 *
 * @method static \Timatic\Factories\PeriodFactory testFactory()
 */
class Period extends SpatieData
{
    /** @use HasTestFactory<PeriodFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
    ) {}
}
