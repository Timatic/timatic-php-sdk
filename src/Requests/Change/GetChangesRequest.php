<?php

namespace Timatic\SDK\Requests\Change;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Dto\Change;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getChanges
 */
class GetChangesRequest extends Request implements Paginatable
{
    protected $model = Change::class;

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
        return '/changes';
    }

    public function __construct() {}
}
