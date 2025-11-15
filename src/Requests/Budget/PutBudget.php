<?php

namespace Timatic\SDK\Requests\Budget;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * putBudget
 */
class PutBudget extends Request
{
	protected Method $method = Method::PUT;


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
