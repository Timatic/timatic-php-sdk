<?php

namespace Timatic\SDK\Requests\MarkAsInvoiced;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * postEntryMarkAsInvoiced
 */
class PostEntryMarkAsInvoicedRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/entries/{$this->entry}/mark-as-invoiced";
    }

    public function __construct(
        protected string $entry,
        protected Model $data,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data->toJsonApi();
    }
}
