<?php

namespace Timatic\SDK\Requests\BudgetType;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBudgetTypes
 */
class GetBudgetTypes extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/budget-types";
	}


	public function __construct()
	{
	}
}
