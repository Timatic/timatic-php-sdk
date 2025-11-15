<?php

namespace Timatic\SDK\Requests\EntrySuggestion;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEntrySuggestion
 */
class GetEntrySuggestion extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/entry-suggestions/{$this->entrySuggestion}";
	}


	/**
	 * @param string $entrySuggestion
	 */
	public function __construct(
		protected string $entrySuggestion,
	) {
	}
}
