<?php

namespace Timatic\SDK\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEntry
 */
class GetEntryRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/entries/{$this->entry}";
    }

    public function __construct(
        protected string $entry,
    ) {}
}
