<?php

namespace Timatic\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\Budget;
use Timatic\Foundation\Hydration\Facades\Hydrator;
use Timatic\Foundation\Requests\Concerns\HasFilters;
use Timatic\Foundation\Requests\Concerns\HasIncludes;

/**
 * budgets.index
 */
class BudgetsCollectionRequest extends Request implements Paginatable
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

    /**
     * @param  null|int  $pagesize  The number of results that will be returned per page.
     * @param  null|int  $pagenumber  The page number to start the pagination from.
     */
    public function __construct(
        protected ?int $pagesize = null,
        protected ?int $pagenumber = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page[size]' => $this->pagesize, 'page[number]' => $this->pagenumber]);
    }
}
