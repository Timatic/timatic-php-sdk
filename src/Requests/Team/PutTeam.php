<?php

namespace Timatic\SDK\Requests\Team;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * putTeam
 */
class PutTeam extends Request
{
	protected Method $method = Method::PUT;


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
