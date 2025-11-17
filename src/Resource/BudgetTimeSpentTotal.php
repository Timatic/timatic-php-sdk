<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\BudgetTimeSpentTotal\GetBudgetTimeSpentTotalsRequest;

class BudgetTimeSpentTotal extends BaseResource
{
    public function getBudgetTimeSpentTotals(?string $filterbudgetId = null, ?string $filterbudgetIdeq = null): Response
    {
        return $this->connector->send(new GetBudgetTimeSpentTotalsRequest($filterbudgetId, $filterbudgetIdeq));
    }
}
