<?php

namespace Timatic\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\EntrySuggestion;
use Timatic\Foundation\JsonApi\JsonApiTransformer;
use Timatic\Foundation\Requests\Concerns\HasFilters;
use Timatic\Foundation\Requests\Concerns\HasIncludes;

/**
 * entry-suggestions.index
 */
class EntrySuggestionsCollectionRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            EntrySuggestion::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => EntrySuggestion::from($flat));
    }

    /**
     * Include the activities relationship in the response
     */
    public function includeActivities(): static
    {
        return $this->addInclude('activities');
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
