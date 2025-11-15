<?php

namespace Timatic\SDK\Requests\Me;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getMes
 */
class GetMes extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/me";
	}


	public function __construct()
	{
	}
}
