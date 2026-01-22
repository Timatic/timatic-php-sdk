<?php

namespace Timatic\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * customers.destroy
 */
class CustomersDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

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
