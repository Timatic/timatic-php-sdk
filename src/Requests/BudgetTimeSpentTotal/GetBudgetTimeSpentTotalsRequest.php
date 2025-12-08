<?php

// auto-generated

namespace Timatic\Requests\BudgetTimeSpentTotal;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\BudgetTimeSpentTotal;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Requests\HasFilters;

/**
 * getBudgetTimeSpentTotals
 */
class GetBudgetTimeSpentTotalsRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = BudgetTimeSpentTotal::class;

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
        return '/budget-time-spent-totals';
    }

    public function __construct() {}
}
