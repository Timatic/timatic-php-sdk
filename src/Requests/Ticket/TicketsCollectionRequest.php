<?php

namespace Timatic\Requests\Ticket;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\DataTransferObjects\Ticket;
use Timatic\Foundation\JsonApi\JsonApiTransformer;
use Timatic\Foundation\Requests\Concerns\HasFilters;

/**
 * tickets.index
 */
class TicketsCollectionRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            Ticket::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => Ticket::from($flat));
    }

    public function resolveEndpoint(): string
    {
        return '/tickets';
    }

    public function __construct(
        protected ?int $pagesize = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page[size]' => $this->pagesize]);
    }
}
