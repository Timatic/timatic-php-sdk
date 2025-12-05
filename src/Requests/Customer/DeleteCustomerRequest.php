<?php

// auto-generated

namespace Timatic\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteCustomer
 */
class DeleteCustomerRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/customers/{$this->customerId}";
    }

    public function __construct(
        protected string $customerId,
    ) {}
}
