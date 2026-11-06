<?php

namespace Timatic\DataTransferObjects;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\UpdateTeamFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * TeamRequest
 *
 *
 * @method static \Timatic\Factories\UpdateTeamFactory testFactory()
 */
#[JsonApiType('teams')]
class UpdateTeam extends SpatieData
{
    /** @use HasTestFactory<UpdateTeamFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $externalId = null,
        public ?string $name = null,
    ) {}
}
