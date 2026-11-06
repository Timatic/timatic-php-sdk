<?php

namespace Timatic\DataTransferObjects;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\ExportFormatFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * ExportFormat
 *
 *
 * @method static \Timatic\Factories\ExportFormatFactory testFactory()
 */
class ExportFormat extends SpatieData
{
    /** @use HasTestFactory<ExportFormatFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $label = null,
        public ?string $periodOptions = null,
        public ?string $extension = null,
    ) {}
}
