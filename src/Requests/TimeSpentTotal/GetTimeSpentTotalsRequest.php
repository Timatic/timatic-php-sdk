<?php

// auto-generated

namespace Timatic\Requests\TimeSpentTotal;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Concerns\HasFilters;
use Timatic\Dto\TimeSpentTotal;
use Timatic\Hydration\Facades\Hydrator;

/**
 * getTimeSpentTotals
 */
class GetTimeSpentTotalsRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = TimeSpentTotal::class;

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
        return '/time-spent-totals';
    }

    public function __construct() {}
}
