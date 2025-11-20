<?php

namespace Timatic\SDK\Requests\BudgetTimeSpentTotal;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;

/**
 * getBudgetTimeSpentTotals
 */
class GetBudgetTimeSpentTotalsRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/budget-time-spent-totals';
    }

    public function __construct() {}
}
