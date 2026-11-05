<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\TeamRequestFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * TeamRequest
 *
 *
 * @method static \Timatic\Factories\TeamRequestFactory testFactory()
 */
#[JsonApiType('teams')]
class TeamRequest extends SpatieData
{
    /** @use HasTestFactory<TeamRequestFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $externalId = null,
        public ?string $name = null,
    ) {}
}
