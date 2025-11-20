<?php

namespace Timatic\SDK\Requests\EntrySuggestion;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;

/**
 * getEntrySuggestions
 */
class GetEntrySuggestionsRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/entry-suggestions';
    }

    public function __construct() {}
}
