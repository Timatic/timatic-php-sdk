<?php

namespace Timatic\SDK\Requests\MarkAsExported;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * postOvertimeMarkAsExported
 */
class PostOvertimeMarkAsExported extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/overtimes/{$this->overtime}/mark-as-exported";
	}


	/**
	 * @param string $overtime
	 */
	public function __construct(
		protected string $overtime,
	) {
	}
}
