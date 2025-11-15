<?php

namespace Timatic\SDK\Requests\User;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getUser
 */
class GetUser extends Request
{
	protected Method $method = Method::GET;


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
