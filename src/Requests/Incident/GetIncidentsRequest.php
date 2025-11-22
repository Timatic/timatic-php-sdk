<?php

namespace Timatic\SDK\Requests\Incident;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Dto\Incident;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getIncidents
 */
class GetIncidentsRequest extends Request implements Paginatable
{
    protected $model = Incident::class;

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
        return '/incidents';
    }

    public function __construct() {}
}
