<?php

namespace Timatic\SDK\Requests\Team;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getTeams
 */
class GetTeams extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/teams";
	}


	public function __construct()
	{
	}
}
