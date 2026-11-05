<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\CorrectionUpdateRequestFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * CorrectionUpdateRequest
 *
 *
 * @method static \Timatic\Factories\CorrectionUpdateRequestFactory testFactory()
 */
#[JsonApiType('corrections')]
class CorrectionUpdateRequest extends SpatieData
{
    /** @use HasTestFactory<CorrectionUpdateRequestFactory> */
    use HasTestFactory;

    public function __construct(
        public ?int $newEntryId = null,
    ) {}
}
