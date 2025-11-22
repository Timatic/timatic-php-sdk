<?php

namespace Timatic\SDK\Requests\UserCustomerHoursAggregate;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;
use Timatic\SDK\Dto\UserCustomerHoursAggregate;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getUserCustomerHoursAggregates
 */
class GetUserCustomerHoursAggregatesRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = UserCustomerHoursAggregate::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrateCollection(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return '/user-customer-hours-aggregates';
    }

    public function __construct() {}
}
