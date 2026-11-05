<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\ProjectMappingFactory;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * ProjectMapping
 *
 *
 * @method static \Timatic\Factories\ProjectMappingFactory testFactory()
 */
class ProjectMapping extends SpatieData
{
    /** @use HasTestFactory<ProjectMappingFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $id = null,
        public ?string $projectKey = null,
        public ?string $projectName = null,
        public ?int $customerId = null,
        public ?int $budgetId = null,
        public ?bool $isArchived = null,
    ) {}
}
