<?php

namespace Timatic\SDK\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getCustomers
 */
class GetCustomers extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/customers';
    }

    public function __construct(
        protected ?string $filterexternalId = null,
        protected ?string $filterexternalIdeq = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['filter[externalId]' => $this->filterexternalId, 'filter[externalId][eq]' => $this->filterexternalIdeq]);
    }
}
