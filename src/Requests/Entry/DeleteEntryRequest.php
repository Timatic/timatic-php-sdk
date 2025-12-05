<?php

// auto-generated

namespace Timatic\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteEntry
 */
class DeleteEntryRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/entries/{$this->entryId}";
    }

    public function __construct(
        protected string $entryId,
    ) {}
}
