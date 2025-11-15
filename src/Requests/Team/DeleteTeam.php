<?php

namespace Timatic\SDK\Requests\Team;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * deleteTeam
 */
class DeleteTeam extends Request
{
	protected Method $method = Method::DELETE;


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
