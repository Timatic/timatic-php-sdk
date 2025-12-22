<?php

// auto-generated

namespace Timatic\Dto;

use Timatic\Hydration\Attributes\DateTime;
use Timatic\Hydration\Attributes\Property;
use Timatic\Hydration\Attributes\Relationship;
use Timatic\Hydration\Model;
use Timatic\Hydration\RelationType;

/**
 * Correction
 */
class Correction extends Model
{
    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;

    #[Relationship(Entry::class, RelationType::One)]
    public ?Entry $correctedEntry = null;

    #[Relationship(Entry::class, RelationType::One)]
    public ?Entry $correctionEntry = null;

    #[Relationship(Entry::class, RelationType::One)]
    public ?Entry $newEntry = null;
}
