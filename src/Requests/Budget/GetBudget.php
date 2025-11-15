<?php

namespace Timatic\SDK\Requests\Budget;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBudget
 */
class GetBudget extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/budgets/{$this->budget}";
	}


	/**
	 * @param string $budget
	 */
	public function __construct(
		protected string $budget,
	) {
	}
}
