<?php

namespace Timatic\SDK\Requests\User;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * patchUser
 */
class PatchUser extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::PATCH;


	public function resolveEndpoint(): string
	{
		return "/users/{$this->user}";
	}


	/**
	 * @param string $user
	 */
	public function __construct(
		protected string $user,
	) {
	}
}
