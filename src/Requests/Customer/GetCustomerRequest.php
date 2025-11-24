<?php

namespace Timatic\SDK\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\Customer;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getCustomer
 */
class GetCustomerRequest extends Request
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

    public function __construct(
        protected string $customerId,
    ) {}
}
