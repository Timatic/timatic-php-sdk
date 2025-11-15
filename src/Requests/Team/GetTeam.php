<?php

namespace Timatic\SDK\Requests\Team;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getTeam
 */
class GetTeam extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/teams/{$this->team}";
	}


	/**
	 * @param string $team
	 */
	public function __construct(
		protected string $team,
	) {
	}
}
