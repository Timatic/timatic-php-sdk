<?php

namespace Timatic\SDK\Requests\Entry;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * patchEntry
 */
class PatchEntry extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::PATCH;


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
