<?php

namespace Timatic\SDK\Requests\BudgetTimeSpentTotal;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBudgetTimeSpentTotals
 */
class GetBudgetTimeSpentTotals extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/budget-time-spent-totals";
	}


	/**
	 * @param null|string $filterbudgetId
	 * @param null|string $filterbudgetIdeq
	 */
	public function __construct(
		protected ?string $filterbudgetId = null,
		protected ?string $filterbudgetIdeq = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['filter[budgetId]' => $this->filterbudgetId, 'filter[budgetId][eq]' => $this->filterbudgetIdeq]);
	}
}
