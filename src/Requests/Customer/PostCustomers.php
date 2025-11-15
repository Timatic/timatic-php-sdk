<?php

namespace Timatic\SDK\Requests\Customer;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * postCustomers
 */
class PostCustomers extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/customers";
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
