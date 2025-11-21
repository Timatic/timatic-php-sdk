<?php

namespace Timatic\SDK\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;

/**
 * getEntries
 */
class GetEntriesRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

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
