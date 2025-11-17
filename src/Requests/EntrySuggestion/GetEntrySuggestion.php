<?php

namespace Timatic\SDK\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEntrySuggestion
 */
class GetEntrySuggestion extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/entry-suggestions/{$this->entrySuggestion}";
    }

    public function __construct(
        protected string $entrySuggestion,
    ) {}
}
