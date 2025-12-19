<?php

// auto-generated

namespace Timatic\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\Entry;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Requests\Concerns\HasFilters;
use Timatic\Requests\Concerns\HasIncludes;

/**
 * getEntries
 */
class GetEntriesCollectionRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected $model = Entry::class;

    protected Method $method = Method::GET;

    /**
     * Include the personalOvertime relationship in the response
     */
    public function includePersonalOvertime(): static
    {
        return $this->addInclude('personalOvertime');
    }

    /**
     * Include the customerOvertime relationship in the response
     */
    public function includeCustomerOvertime(): static
    {
        return $this->addInclude('customerOvertime');
    }

    /**
     * Include the correctionEntryCorrection relationship in the response
     */
    public function includeCorrectionEntryCorrection(): static
    {
        return $this->addInclude('correctionEntryCorrection');
    }

    /**
     * Include the correctedEntryCorrection relationship in the response
     */
    public function includeCorrectedEntryCorrection(): static
    {
        return $this->addInclude('correctedEntryCorrection');
    }

    /**
     * Include the newEntryCorrection relationship in the response
     */
    public function includeNewEntryCorrection(): static
    {
        return $this->addInclude('newEntryCorrection');
    }

    /**
     * Include the customer relationship in the response
     */
    public function includeCustomer(): static
    {
        return $this->addInclude('customer');
    }

    /**
     * Include the budget relationship in the response
     */
    public function includeBudget(): static
    {
        return $this->addInclude('budget');
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
        return '/entries';
    }

    public function __construct() {}
}
