<?php

// auto-generated

namespace Timatic\Requests\UserCustomerHoursAggregate;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\UserCustomerHoursAggregate;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Requests\HasFilters;

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
