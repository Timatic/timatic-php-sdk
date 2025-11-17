<?php

namespace Timatic\SDK\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getUsers
 */
class GetUsersRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/users';
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
