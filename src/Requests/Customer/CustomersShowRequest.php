<?php

namespace Timatic\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Customer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * customers.show
 */
class CustomersShowRequest extends Request
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Customer::from(JsonApiTransformer::flatten(
            Customer::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return "/customers/{$this->customerId}";
    }

    /**
     * @param  mixed  $customerId  The customer ID
     */
    public function __construct(
        protected mixed $customerId,
    ) {}
}
