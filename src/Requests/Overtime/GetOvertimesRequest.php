<?php

// auto-generated

namespace Timatic\Requests\Overtime;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Concerns\HasFilters;
use Timatic\Dto\Overtime;
use Timatic\Hydration\Facades\Hydrator;

/**
 * getOvertimes
 */
class GetOvertimesRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = Overtime::class;

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
        return '/overtimes';
    }

    public function __construct() {}
}
