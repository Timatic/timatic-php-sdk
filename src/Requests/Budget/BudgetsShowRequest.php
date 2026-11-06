<?php

namespace Timatic\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\DataTransferObjects\Budget;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * budgets.show
 */
class BudgetsShowRequest extends Request
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Budget::from(JsonApiTransformer::flatten(
            Budget::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return "/budgets/{$this->budgetId}";
    }

    /**
     * @param  int  $budgetId  The budget ID
     */
    public function __construct(
        protected int $budgetId,
    ) {}
}
