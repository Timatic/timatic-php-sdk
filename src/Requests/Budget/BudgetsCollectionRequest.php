<?php

namespace Timatic\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\Budget;
use Timatic\Foundation\JsonApi\JsonApiTransformer;
use Timatic\Foundation\Requests\Concerns\HasFilters;
use Timatic\Foundation\Requests\Concerns\HasIncludes;

/**
 * budgets.index
 */
class BudgetsCollectionRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            Budget::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => Budget::from($flat));
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

    /**
     * Include the supervisor relationship in the response
     */
    public function includeSupervisor(): static
    {
        return $this->addInclude('supervisor');
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
