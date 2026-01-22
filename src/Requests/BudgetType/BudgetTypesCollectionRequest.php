<?php

namespace Timatic\Requests\BudgetType;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\BudgetType;
use Timatic\Foundation\Hydration\Facades\Hydrator;

/**
 * budget-types.index
 */
class BudgetTypesCollectionRequest extends Request implements Paginatable
{
    protected $model = BudgetType::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrateCollection(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return '/budget-types';
    }

    public function __construct() {}
}
