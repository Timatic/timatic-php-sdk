<?php

namespace Timatic\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\EntrySuggestion;
use Timatic\Foundation\Hydration\Facades\Hydrator;

/**
 * entry-suggestions.show
 */
class EntrySuggestionsShowRequest extends Request
{
    protected $model = EntrySuggestion::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrate(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

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
