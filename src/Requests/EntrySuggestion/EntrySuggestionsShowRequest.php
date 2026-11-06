<?php

namespace Timatic\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\DataTransferObjects\EntrySuggestion;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * entry-suggestions.show
 */
class EntrySuggestionsShowRequest extends Request
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return EntrySuggestion::from(JsonApiTransformer::flatten(
            EntrySuggestion::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

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
