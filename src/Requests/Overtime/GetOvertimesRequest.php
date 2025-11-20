<?php

namespace Timatic\SDK\Requests\Overtime;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;

/**
 * getOvertimes
 */
class GetOvertimesRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/overtimes';
    }

    public function __construct() {}
}
