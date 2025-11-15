<?php

namespace Timatic\SDK\Requests\Customer;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getCustomer
 */
class GetCustomer extends Request
{
	protected Method $method = Method::GET;


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
