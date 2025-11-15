<?php

namespace Timatic\SDK\Requests\Customer;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * putCustomer
 */
class PutCustomer extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/customers/{$this->customer}";
	}


	/**
	 * @param string $customer
	 */
	public function __construct(
		protected string $customer,
	) {
	}
}
