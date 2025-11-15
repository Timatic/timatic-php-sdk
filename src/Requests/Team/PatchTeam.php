<?php

namespace Timatic\SDK\Requests\Team;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * patchTeam
 */
class PatchTeam extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::PATCH;


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
