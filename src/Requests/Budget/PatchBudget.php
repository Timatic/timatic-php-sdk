<?php

namespace Timatic\SDK\Requests\Budget;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * patchBudget
 */
class PatchBudget extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::PATCH;


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
