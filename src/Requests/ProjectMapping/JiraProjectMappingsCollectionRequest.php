<?php

namespace Timatic\Requests\ProjectMapping;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\ProjectMapping;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * jira.project-mappings.index
 */
class JiraProjectMappingsCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            ProjectMapping::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => ProjectMapping::from($flat));
    }

    public function resolveEndpoint(): string
    {
        return '/jira/project-mappings';
    }

    public function __construct() {}
}
