<?php

namespace Timatic\Requests\BudgetType;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\BudgetType;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * budget-types.index
 */
class BudgetTypesCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            BudgetType::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => BudgetType::from($flat));
    }

    public function resolveEndpoint(): string
    {
        return '/budget-types';
    }

    public function __construct() {}
}
