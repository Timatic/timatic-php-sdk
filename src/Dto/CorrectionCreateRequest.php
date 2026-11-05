<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\CorrectionCreateRequestFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * CorrectionCreateRequest
 *
 *
 * @method static \Timatic\Factories\CorrectionCreateRequestFactory testFactory()
 */
#[JsonApiType('corrections')]
class CorrectionCreateRequest extends SpatieData
{
    /** @use HasTestFactory<CorrectionCreateRequestFactory> */
    use HasTestFactory;

    public function __construct(
        public ?int $correctedEntryId = null,
        public ?int $newEntryId = null,
    ) {}
}
