<?php

namespace Timatic\SDK\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;
use Timatic\SDK\Dto\Budget;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getBudgets
 */
class GetBudgetsRequest extends Request implements Paginatable
{
    use HasFilters;

    protected $model = Budget::class;

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
        return '/budgets';
    }

    public function __construct(
        protected ?string $include = null,
    ) {}

    protected function defaultQuery(): array
    {
        return array_filter(['include' => $this->include]);
    }
}
