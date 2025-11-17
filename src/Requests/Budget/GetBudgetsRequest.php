<?php

namespace Timatic\SDK\Requests\Budget;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getBudgets
 */
class GetBudgetsRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/budgets';
    }

    public function __construct(
        protected ?int $filtercustomerId = null,
        protected ?int $filtercustomerIdeq = null,
        protected ?int $filtercustomerIdnq = null,
        protected ?int $filtercustomerIdgt = null,
        protected ?int $filtercustomerIdlt = null,
        protected ?int $filtercustomerIdgte = null,
        protected ?int $filtercustomerIdlte = null,
        protected ?int $filtercustomerIdcontains = null,
        protected ?string $filterbudgetTypeId = null,
        protected ?string $filterbudgetTypeIdeq = null,
        protected ?string $filterbudgetTypeIdnq = null,
        protected ?string $filterbudgetTypeIdgt = null,
        protected ?string $filterbudgetTypeIdlt = null,
        protected ?string $filterbudgetTypeIdgte = null,
        protected ?string $filterbudgetTypeIdlte = null,
        protected ?string $filterbudgetTypeIdcontains = null,
        protected ?string $filterisArchived = null,
        protected ?string $filtercustomerExternalId = null,
        protected ?string $filtershowToCustomer = null,
        protected ?string $include = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'filter[customerId]' => $this->filtercustomerId,
            'filter[customerId][eq]' => $this->filtercustomerIdeq,
            'filter[customerId][nq]' => $this->filtercustomerIdnq,
            'filter[customerId][gt]' => $this->filtercustomerIdgt,
            'filter[customerId][lt]' => $this->filtercustomerIdlt,
            'filter[customerId][gte]' => $this->filtercustomerIdgte,
            'filter[customerId][lte]' => $this->filtercustomerIdlte,
            'filter[customerId][contains]' => $this->filtercustomerIdcontains,
            'filter[budgetTypeId]' => $this->filterbudgetTypeId,
            'filter[budgetTypeId][eq]' => $this->filterbudgetTypeIdeq,
            'filter[budgetTypeId][nq]' => $this->filterbudgetTypeIdnq,
            'filter[budgetTypeId][gt]' => $this->filterbudgetTypeIdgt,
            'filter[budgetTypeId][lt]' => $this->filterbudgetTypeIdlt,
            'filter[budgetTypeId][gte]' => $this->filterbudgetTypeIdgte,
            'filter[budgetTypeId][lte]' => $this->filterbudgetTypeIdlte,
            'filter[budgetTypeId][contains]' => $this->filterbudgetTypeIdcontains,
            'filter[isArchived]' => $this->filterisArchived,
            'filter[customerExternalId]' => $this->filtercustomerExternalId,
            'filter[showToCustomer]' => $this->filtershowToCustomer,
            'include' => $this->include,
        ]);
    }
}
