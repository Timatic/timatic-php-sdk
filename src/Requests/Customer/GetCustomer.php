<?php

namespace Timatic\SDK\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getCustomer
 */
class GetCustomer extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/customers/{$this->customer}";
    }

    public function __construct(
        protected string $customer,
    ) {}
}
