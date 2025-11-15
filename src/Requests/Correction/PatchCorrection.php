<?php

namespace Timatic\SDK\Requests\Correction;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * patchCorrection
 */
class PatchCorrection extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::PATCH;


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
