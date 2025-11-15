<?php

namespace Timatic\SDK\Requests\Entry;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteEntry
 */
class DeleteEntry extends Request
{
	protected Method $method = Method::DELETE;


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
