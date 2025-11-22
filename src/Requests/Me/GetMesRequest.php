<?php

namespace Timatic\SDK\Requests\Me;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Dto\Me;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getMes
 */
class GetMesRequest extends Request implements Paginatable
{
    protected $model = Me::class;

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
        return '/me';
    }

    public function __construct() {}
}
