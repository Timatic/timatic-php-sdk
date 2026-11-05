<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\TeamFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * Team
 *
 *
 * @method static \Timatic\Factories\TeamFactory testFactory()
 */
class Team extends SpatieData
{
    /** @use HasTestFactory<TeamFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $externalId = null,
        public ?string $name = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    ) {}
}
