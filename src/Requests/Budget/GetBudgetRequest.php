<?php

// auto-generated

namespace Timatic\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Budget;
use Timatic\Hydration\Facades\Hydrator;

/**
 * getBudget
 */
class GetBudgetRequest extends Request
{
    protected $model = Budget::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrate(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return "/budgets/{$this->budgetId}";
    }

    public function __construct(
        protected string $budgetId,
    ) {}
}
