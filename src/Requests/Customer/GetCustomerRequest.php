<?php

namespace Timatic\SDK\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getCustomer
 */
class GetCustomerRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/customers/{$this->customerId}";
    }

    public function __construct(
        protected string $customerId,
    ) {}
}
