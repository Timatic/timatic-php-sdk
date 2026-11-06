<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\UpdateCorrectionFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * CorrectionUpdateRequest
 *
 *
 * @method static \Timatic\Factories\UpdateCorrectionFactory testFactory()
 */
#[JsonApiType('corrections')]
class UpdateCorrection extends SpatieData
{
    /** @use HasTestFactory<UpdateCorrectionFactory> */
    use HasTestFactory;

    public function __construct(
        public ?int $newEntryId = null,
    ) {}
}
