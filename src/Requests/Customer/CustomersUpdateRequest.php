<?php

namespace Timatic\Requests\Customer;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\DataTransferObjects\Customer;
use Timatic\DataTransferObjects\UpdateCustomer;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * customers.update
 */
class CustomersUpdateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

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
     * @param  null|UpdateCustomer  $data  Request data
     */
    public function __construct(
        protected mixed $customerId,
        protected ?UpdateCustomer $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
