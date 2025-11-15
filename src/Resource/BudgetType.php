<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\BudgetType\GetBudgetTypes;

class BudgetType extends BaseResource
{
	public function getBudgetTypes(): Response
	{
		return $this->connector->send(new GetBudgetTypes());
	}
}
