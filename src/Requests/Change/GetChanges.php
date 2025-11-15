<?php

namespace Timatic\SDK\Requests\Change;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getChanges
 */
class GetChanges extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/changes";
	}


	public function __construct()
	{
	}
}
