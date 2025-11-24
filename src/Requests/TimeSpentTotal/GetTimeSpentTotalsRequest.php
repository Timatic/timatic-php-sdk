<?php

namespace Timatic\SDK\Requests\TimeSpentTotal;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;
use Timatic\SDK\Dto\TimeSpentTotal;
use Timatic\SDK\Hydration\Facades\Hydrator;

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
