<?php

namespace Timatic\SDK\Requests\Entry;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * postEntries
 */
class PostEntriesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/entries';
    }

    public function __construct(
        protected Model $data,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data->toJsonApi();
    }
}
