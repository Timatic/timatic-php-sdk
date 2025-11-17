<?php

namespace Timatic\SDK\Requests\Customer;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * patchCustomer
 */
class PatchCustomerRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function resolveEndpoint(): string
    {
        return "/customers/{$this->customer}";
    }

    public function __construct(
        protected string $customer,
        protected Model $data,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data->toJsonApi();
    }
}
