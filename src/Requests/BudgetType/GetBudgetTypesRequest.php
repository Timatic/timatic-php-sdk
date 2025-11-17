<?php

namespace Timatic\SDK\Requests\BudgetType;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getBudgetTypes
 */
class GetBudgetTypesRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/budget-types';
    }

    public function __construct() {}
}
