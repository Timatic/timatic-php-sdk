<?php

namespace Timatic\SDK\Requests\UserCustomerHoursAggregate;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;

/**
 * getUserCustomerHoursAggregates
 */
class GetUserCustomerHoursAggregatesRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/user-customer-hours-aggregates';
    }

    public function __construct() {}
}
