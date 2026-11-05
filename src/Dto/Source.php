<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\SourceFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * Source
 *
 *
 * @method static \Timatic\Factories\SourceFactory testFactory()
 */
#[JsonApiType('sources')]
class Source extends SpatieData
{
    /** @use HasTestFactory<SourceFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $key = null,
        public ?string $title = null,
        public ?string $iconUrl = null,
    ) {}
}
