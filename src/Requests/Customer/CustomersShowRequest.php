<?php

// auto-generated

namespace Timatic\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Customer;
use Timatic\Hydration\Facades\Hydrator;

/**
 * customers.show
 */
class CustomersShowRequest extends Request
{
    protected $model = Customer::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrate(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return "/customers/{$this->customerId}";
    }

    /**
     * @param  int  $customerId  The customer ID
     */
    public function __construct(
        protected int $customerId,
    ) {}
}
