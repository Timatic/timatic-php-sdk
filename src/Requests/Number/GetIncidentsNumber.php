<?php

namespace Timatic\SDK\Requests\Number;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getIncidentsNumber
 */
class GetIncidentsNumber extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/incidents/number/{$this->incident}";
	}


	/**
	 * @param string $incident
	 */
	public function __construct(
		protected string $incident,
	) {
	}
}
