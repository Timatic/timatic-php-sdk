<?php

namespace Timatic\SDK\Requests\User;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getUsers
 */
class GetUsers extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/users";
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
