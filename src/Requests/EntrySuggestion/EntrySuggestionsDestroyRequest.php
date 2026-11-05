<?php

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
     * @param  mixed  $entrySuggestionId  The entry suggestion ID
     */
    public function __construct(
        protected mixed $entrySuggestionId,
    ) {}
}
