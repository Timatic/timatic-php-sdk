<?php

// auto-generated

namespace Timatic\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * entry-suggestions.destroy
 */
class EntrySuggestionsDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/entry-suggestions/{$this->entrySuggestionId}";
    }

    /**
     * @param  int  $entrySuggestionId  The entry suggestion ID
     */
    public function __construct(
        protected int $entrySuggestionId,
    ) {}
}
