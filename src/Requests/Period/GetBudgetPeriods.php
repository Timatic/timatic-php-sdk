<?php

namespace Timatic\SDK\Requests\Period;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBudgetPeriods
 */
class GetBudgetPeriods extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/budgets/{$this->budget}/periods";
    }

    public function __construct(
        protected string $budget,
    ) {}
}
