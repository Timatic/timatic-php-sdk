<?php

// auto-generated

namespace Timatic\Requests\BudgetType;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\BudgetType;
use Timatic\Hydration\Facades\Hydrator;

/**
 * getBudgetTypes
 */
class GetBudgetTypesRequest extends Request implements Paginatable
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
