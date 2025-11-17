<?php

namespace Timatic\SDK\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteCustomer
 */
class DeleteCustomer extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/customers/{$this->customer}";
    }

    public function __construct(
        protected string $customer,
    ) {}
}
