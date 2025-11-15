<?php

namespace Timatic\SDK\Requests\User;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * putUser
 */
class PutUser extends Request
{
	protected Method $method = Method::PUT;


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
