<?php

namespace Timatic\SDK\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getEntrySuggestions
 */
class GetEntrySuggestionsRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/entry-suggestions';
    }

    public function __construct(
        protected ?string $filterdate = null,
        protected ?string $filterdateeq = null,
        protected ?string $filterdatenq = null,
        protected ?string $filterdategt = null,
        protected ?string $filterdatelt = null,
        protected ?string $filterdategte = null,
        protected ?string $filterdatelte = null,
        protected ?string $filterdatecontains = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'filter[date]' => $this->filterdate,
            'filter[date][eq]' => $this->filterdateeq,
            'filter[date][nq]' => $this->filterdatenq,
            'filter[date][gt]' => $this->filterdategt,
            'filter[date][lt]' => $this->filterdatelt,
            'filter[date][gte]' => $this->filterdategte,
            'filter[date][lte]' => $this->filterdatelte,
            'filter[date][contains]' => $this->filterdatecontains,
        ]);
    }
}
