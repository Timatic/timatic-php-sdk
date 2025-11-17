<?php

namespace Timatic\SDK\Requests\Entry;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * patchEntry
 */
class PatchEntryRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function resolveEndpoint(): string
    {
        return "/entries/{$this->entry}";
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
