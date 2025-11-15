<?php

namespace Timatic\SDK\Requests\DailyProgress;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getDailyProgresses
 */
class GetDailyProgresses extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/daily-progress";
	}


	public function __construct()
	{
	}
}
