<?php

namespace Timatic\SDK\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Dto\Team;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getTeams
 */
class GetTeamsRequest extends Request implements Paginatable
{
    protected $model = Team::class;

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
        return '/teams';
    }

    public function __construct() {}
}
