<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Period\GetBudgetPeriods;

class Period extends BaseResource
{
	/**
	 * @param string $budget
	 */
	public function getBudgetPeriods(string $budget): Response
	{
		return $this->connector->send(new GetBudgetPeriods($budget));
	}
}
