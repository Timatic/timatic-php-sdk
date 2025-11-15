<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\BudgetTimeSpentTotal\GetBudgetTimeSpentTotals;

class BudgetTimeSpentTotal extends BaseResource
{
	/**
	 * @param string $filterbudgetId
	 * @param string $filterbudgetIdeq
	 */
	public function getBudgetTimeSpentTotals(?string $filterbudgetId = null, ?string $filterbudgetIdeq = null): Response
	{
		return $this->connector->send(new GetBudgetTimeSpentTotals($filterbudgetId, $filterbudgetIdeq));
	}
}
