<?php

namespace Timatic\SDK\Requests\TimeSpentTotal;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;

/**
 * getTimeSpentTotals
 */
class GetTimeSpentTotalsRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/time-spent-totals';
    }

    public function __construct() {}
}
