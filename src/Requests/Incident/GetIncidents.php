<?php

namespace Timatic\SDK\Requests\Incident;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getIncidents
 */
class GetIncidents extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/incidents";
	}


	public function __construct()
	{
	}
}
