<?php

// auto-generated

namespace Timatic\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\Budget;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Requests\Concerns\HasFilters;
use Timatic\Requests\Concerns\HasIncludes;

/**
 * getBudgets
 */
class GetBudgetsCollectionRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected $model = Budget::class;

    protected Method $method = Method::GET;

    /**
     * Include the entries relationship in the response
     */
    public function includeEntries(): static
    {
        return $this->addInclude('entries');
    }

    /**
     * Include the budgetType relationship in the response
     */
    public function includeBudgetType(): static
    {
        return $this->addInclude('budgetType');
    }

    /**
     * Include the currentPeriod relationship in the response
     */
    public function includeCurrentPeriod(): static
    {
        return $this->addInclude('currentPeriod');
    }

    /**
     * Include the lastPeriod relationship in the response
     */
    public function includeLastPeriod(): static
    {
        return $this->addInclude('lastPeriod');
    }

    /**
     * Include the customer relationship in the response
     */
    public function includeCustomer(): static
    {
        return $this->addInclude('customer');
    }

    /**
     * Include the allowedUsers relationship in the response
     */
    public function includeAllowedUsers(): static
    {
        return $this->addInclude('allowedUsers');
    }

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

    public function __construct() {}
}
