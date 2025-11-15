<?php

namespace Timatic\SDK\Requests\Entry;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * putEntry
 */
class PutEntry extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/entries/{$this->entry}";
	}


	/**
	 * @param string $entry
	 */
	public function __construct(
		protected string $entry,
	) {
	}
}
