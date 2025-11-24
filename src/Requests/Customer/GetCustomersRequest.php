<?php

namespace Timatic\SDK\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;
use Timatic\SDK\Dto\Customer;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getCustomers
 */
class GetCustomersRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = Customer::class;

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
        return '/customers';
    }

    public function __construct() {}
}
