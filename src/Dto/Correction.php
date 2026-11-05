<?php

namespace Timatic\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\CorrectionFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * Correction
 *
 *
 * @method static \Timatic\Factories\CorrectionFactory testFactory()
 */
class Correction extends SpatieData
{
    /** @use HasTestFactory<CorrectionFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        #[JsonApiRelationship(Entry::class, RelationType::One)]
        public ?Entry $correctedEntry = null,
        #[JsonApiRelationship(Entry::class, RelationType::One)]
        public ?Entry $correctionEntry = null,
        #[JsonApiRelationship(Entry::class, RelationType::One)]
        public ?Entry $newEntry = null,
    ) {}
}
