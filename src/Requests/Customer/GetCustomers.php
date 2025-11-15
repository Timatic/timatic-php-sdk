<?php

namespace Timatic\SDK\Requests\Customer;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getCustomers
 */
class GetCustomers extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/customers";
	}


	/**
	 * @param null|string $filterexternalId
	 * @param null|string $filterexternalIdeq
	 */
	public function __construct(
		protected ?string $filterexternalId = null,
		protected ?string $filterexternalIdeq = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['filter[externalId]' => $this->filterexternalId, 'filter[externalId][eq]' => $this->filterexternalIdeq]);
	}
}
