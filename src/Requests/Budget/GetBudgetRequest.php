<?php

namespace Timatic\SDK\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBudget
 */
class GetBudgetRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/budgets/{$this->budgetId}";
    }

    public function __construct(
        protected string $budgetId,
    ) {}
}
