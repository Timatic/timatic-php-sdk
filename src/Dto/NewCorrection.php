<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\NewCorrectionFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * CorrectionCreateRequest
 *
 *
 * @method static \Timatic\Factories\NewCorrectionFactory testFactory()
 */
#[JsonApiType('corrections')]
class NewCorrection extends SpatieData
{
    /** @use HasTestFactory<NewCorrectionFactory> */
    use HasTestFactory;

    public function __construct(
        public ?int $correctedEntryId = null,
        public ?int $newEntryId = null,
    ) {}
}
