<?php

namespace Timatic\SDK\Requests\Correction;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * putCorrection
 */
class PutCorrection extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/corrections/{$this->correction}";
	}


	/**
	 * @param string $correction
	 */
	public function __construct(
		protected string $correction,
	) {
	}
}
