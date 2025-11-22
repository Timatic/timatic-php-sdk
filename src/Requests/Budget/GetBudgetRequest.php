<?php

namespace Timatic\SDK\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\Budget;
use Timatic\SDK\Hydration\Facades\Hydrator;

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
