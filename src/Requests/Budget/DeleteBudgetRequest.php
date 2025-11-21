<?php

namespace Timatic\SDK\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteBudget
 */
class DeleteBudgetRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/budgets/{$this->budgetId}";
    }

    public function __construct(
        protected string $budgetId,
    ) {}
}
