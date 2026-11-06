<?php

namespace Timatic\DataTransferObjects;

use Carbon\Carbon;
use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\OvertimeFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiRelationship;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;
use Timatic\Foundation\JsonApi\RelationType;

/**
 * Overtime
 *
 *
 * @method static \Timatic\Factories\OvertimeFactory testFactory()
 */
#[JsonApiType('overtimes')]
class Overtime extends SpatieData
{
    /** @use HasTestFactory<OvertimeFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?int $entryId = null,
        public ?string $overtimeTypeId = null,
        public ?Carbon $startedAt = null,
        public ?Carbon $endedAt = null,
        public ?array $percentages = null,
        public ?Carbon $approvedAt = null,
        public ?int $approvedByUserId = null,
        public ?Carbon $exportedAt = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
        #[JsonApiRelationship(OvertimeType::class, RelationType::One)]
        public ?OvertimeType $overtimeType = null,
        #[JsonApiRelationship(Entry::class, RelationType::One)]
        public ?Entry $entry = null,
    ) {}
}
