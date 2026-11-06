<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\NewTeamFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * TeamRequest
 *
 *
 * @method static \Timatic\Factories\NewTeamFactory testFactory()
 */
#[JsonApiType('teams')]
class NewTeam extends SpatieData
{
    /** @use HasTestFactory<NewTeamFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $externalId = null,
        public ?string $name = null,
    ) {}
}
