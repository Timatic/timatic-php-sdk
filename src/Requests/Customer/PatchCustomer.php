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
class PatchCustomer extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function resolveEndpoint(): string
    {
        return "/customers/{$this->customer}";
    }

    public function __construct(
        protected string $customer,
        protected Model|array $data,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data instanceof Model
            ? $this->data->toJsonApi()
            : ['data' => $this->data];
    }
}
