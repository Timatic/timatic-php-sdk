<?php

namespace Timatic\SDK\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;
use Timatic\SDK\Dto\EntrySuggestion;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getEntrySuggestions
 */
class GetEntrySuggestionsRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = EntrySuggestion::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrateCollection(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return '/entry-suggestions';
    }

    public function __construct() {}
}
