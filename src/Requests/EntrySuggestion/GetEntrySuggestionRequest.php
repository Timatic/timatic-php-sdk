<?php

namespace Timatic\SDK\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\EntrySuggestion;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getEntrySuggestion
 */
class GetEntrySuggestionRequest extends Request
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

    public function __construct(
        protected string $entrySuggestionId,
    ) {}
}
