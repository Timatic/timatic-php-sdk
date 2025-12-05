<?php

// auto-generated

namespace Timatic\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Concerns\HasFilters;
use Timatic\Dto\Entry;
use Timatic\Hydration\Facades\Hydrator;

/**
 * getEntries
 */
class GetEntriesRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = Entry::class;

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
        return '/entries';
    }

    public function __construct(
        protected ?string $include = null,
    ) {}

    protected function defaultQuery(): array
    {
        return array_filter(['include' => $this->include]);
    }
}
