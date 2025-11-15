<?php

namespace Timatic\SDK\Requests\Budget;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

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
		protected Model|array $data,
	) {
	}


	protected function defaultBody(): array
	{
		return $this->data instanceof Model
		    ? $this->data->toJsonApi()
		    : ['data' => $this->data];
	}
}
