<?php

namespace Timatic\SDK\Requests\Incident;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getIncident
 */
class GetIncident extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/incidents/{$this->incident}";
	}


	/**
	 * @param string $incident
	 */
	public function __construct(
		protected string $incident,
	) {
	}
}
