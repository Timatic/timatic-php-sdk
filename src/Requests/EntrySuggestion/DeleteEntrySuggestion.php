<?php

namespace Timatic\SDK\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteEntrySuggestion
 */
class DeleteEntrySuggestion extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/entry-suggestions/{$this->entrySuggestion}";
    }

    public function __construct(
        protected string $entrySuggestion,
    ) {}
}
