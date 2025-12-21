<?php

// auto-generated

namespace Timatic\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\EntrySuggestion;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Requests\Concerns\HasFilters;
use Timatic\Requests\Concerns\HasIncludes;

/**
 * entry-suggestions.index
 */
class EntrySuggestionsCollectionRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected $model = EntrySuggestion::class;

    protected Method $method = Method::GET;

    /**
     * Include the activities relationship in the response
     */
    public function includeActivities(): static
    {
        return $this->addInclude('activities');
    }

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

    /**
     * @param  null|int  $pagesize  The number of results that will be returned per page.
     * @param  null|int  $pagenumber  The page number to start the pagination from.
     */
    public function __construct(
        protected ?int $pagesize = null,
        protected ?int $pagenumber = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page[size]' => $this->pagesize, 'page[number]' => $this->pagenumber]);
    }
}
