<?php

namespace Timatic\SDK\Requests\User;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteUser
 */
class DeleteUser extends Request
{
	protected Method $method = Method::DELETE;


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
