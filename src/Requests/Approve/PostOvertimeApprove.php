<?php

namespace Timatic\SDK\Requests\Approve;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * postOvertimeApprove
 */
class PostOvertimeApprove extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/overtimes/{$this->overtime}/approve";
	}


	/**
	 * @param string $overtime
	 */
	public function __construct(
		protected string $overtime,
	) {
	}
}
