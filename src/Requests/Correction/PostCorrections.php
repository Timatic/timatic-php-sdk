<?php

namespace Timatic\SDK\Requests\Correction;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * postCorrections
 */
class PostCorrections extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/corrections";
	}


	public function __construct()
	{
	}
}
