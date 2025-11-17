<?php

namespace Timatic\SDK\Requests\BudgetTimeSpentTotal;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getBudgetTimeSpentTotals
 */
class GetBudgetTimeSpentTotals extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/budget-time-spent-totals';
    }

    public function __construct(
        protected ?string $filterbudgetId = null,
        protected ?string $filterbudgetIdeq = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['filter[budgetId]' => $this->filterbudgetId, 'filter[budgetId][eq]' => $this->filterbudgetIdeq]);
    }
}
