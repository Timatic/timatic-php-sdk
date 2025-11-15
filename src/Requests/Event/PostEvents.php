<?php

namespace Timatic\SDK\Requests\Event;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * postEvents
 */
class PostEvents extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/events";
	}


	public function __construct(
		protected Model|array $data,
	) {
	}


	protected function defaultBody(): array
	{
		return $this->data instanceof Model
		    ? $this->data->toJsonApi()
		    : ['data' => $this->data];
	}
}
