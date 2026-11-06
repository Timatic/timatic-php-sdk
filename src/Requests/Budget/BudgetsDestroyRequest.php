<?php

namespace Timatic\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * budgets.destroy
 */
class BudgetsDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

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
