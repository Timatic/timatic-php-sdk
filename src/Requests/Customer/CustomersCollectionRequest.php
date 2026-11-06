<?php

namespace Timatic\Requests\Customer;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\DataTransferObjects\Customer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;
use Timatic\Foundation\Requests\Concerns\HasFilters;
use Timatic\Foundation\Requests\Concerns\HasIncludes;

/**
 * customers.index
 */
class CustomersCollectionRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            Customer::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => Customer::from($flat));
    }

    /**
     * Include the accountManager relationship in the response
     */
    public function includeAccountManager(): static
    {
        return $this->addInclude('accountManager');
    }

    public function resolveEndpoint(): string
    {
        return '/customers';
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
