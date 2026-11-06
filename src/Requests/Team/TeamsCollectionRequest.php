<?php

namespace Timatic\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\DataTransferObjects\Team;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * teams.index
 */
class TeamsCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            Team::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => Team::from($flat));
    }

    public function resolveEndpoint(): string
    {
        return '/teams';
    }

    public function __construct() {}
}
