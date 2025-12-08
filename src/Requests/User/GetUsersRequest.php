<?php

// auto-generated

namespace Timatic\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\User;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Requests\HasFilters;

/**
 * getUsers
 */
class GetUsersRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = User::class;

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
        return '/users';
    }

    public function __construct() {}
}
