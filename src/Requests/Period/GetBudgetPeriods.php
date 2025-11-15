<?php

namespace Timatic\SDK\Requests\Period;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getBudgetPeriods
 */
class GetBudgetPeriods extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/budgets/{$this->budget}/periods";
	}


	/**
	 * @param string $budget
	 */
	public function __construct(
		protected string $budget,
	) {
	}
}
