<?php

namespace Timatic\SDK\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEntrySuggestion
 */
class GetEntrySuggestionRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/entry-suggestions/{$this->entrySuggestionId}";
    }

    public function __construct(
        protected string $entrySuggestionId,
    ) {}
}
