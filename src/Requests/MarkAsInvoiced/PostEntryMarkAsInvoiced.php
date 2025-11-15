<?php

namespace Timatic\SDK\Requests\MarkAsInvoiced;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * postEntryMarkAsInvoiced
 */
class PostEntryMarkAsInvoiced extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/entries/{$this->entry}/mark-as-invoiced";
	}


	/**
	 * @param string $entry
	 */
	public function __construct(
		protected string $entry,
	) {
	}
}
