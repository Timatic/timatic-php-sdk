<?php

namespace Timatic\SDK\Requests\Budget;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * deleteBudget
 */
class DeleteBudget extends Request
{
	protected Method $method = Method::DELETE;


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
