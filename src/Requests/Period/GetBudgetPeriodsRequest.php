<?php

namespace Timatic\SDK\Requests\Period;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\Period;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getBudgetPeriods
 */
class GetBudgetPeriodsRequest extends Request
{
    protected $model = Period::class;

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
        return "/budgets/{$this->budgetId}/periods";
    }

    public function __construct(
        protected string $budgetId,
    ) {}
}
