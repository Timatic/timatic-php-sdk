<?php

namespace Timatic\SDK\Requests\Entry;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getEntry
 */
class GetEntry extends Request
{
	protected Method $method = Method::GET;


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
