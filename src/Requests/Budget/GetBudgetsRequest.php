<?php

namespace Timatic\SDK\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;

/**
 * getBudgets
 */
class GetBudgetsRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/budgets';
    }

    public function __construct(
        protected ?string $include = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['include' => $this->include]);
    }
}
