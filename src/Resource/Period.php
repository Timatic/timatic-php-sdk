<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Period\GetBudgetPeriodsRequest;

class Period extends BaseResource
{
    public function getBudgetPeriods(string $budgetId): Response
    {
        return $this->connector->send(new GetBudgetPeriodsRequest($budgetId));
    }
}
