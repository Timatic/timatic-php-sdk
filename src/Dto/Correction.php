<?php

namespace Timatic\Dto;

use Timatic\Foundation\Hydration\Attributes\DateTime;
use Timatic\Foundation\Hydration\Attributes\Property;
use Timatic\Foundation\Hydration\Attributes\Relationship;
use Timatic\Foundation\Hydration\Model;
use Timatic\Foundation\Hydration\RelationType;

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
