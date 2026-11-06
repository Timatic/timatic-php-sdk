<?php

namespace Timatic\DataTransferObjects;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\TicketActionFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * TicketAction
 *
 *
 * @method static \Timatic\Factories\TicketActionFactory testFactory()
 */
class TicketAction extends SpatieData
{
    /** @use HasTestFactory<TicketActionFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $entryDate = null,
        public ?string $text = null,
        public ?string $personDisplayName = null,
        public ?string $personEmail = null,
    ) {}
}
