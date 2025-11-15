<?php

namespace Timatic\SDK\Requests\Budget;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBudgets
 */
class GetBudgets extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/budgets";
	}


	/**
	 * @param null|int $filtercustomerId
	 * @param null|int $filtercustomerIdeq
	 * @param null|int $filtercustomerIdnq
	 * @param null|int $filtercustomerIdgt
	 * @param null|int $filtercustomerIdlt
	 * @param null|int $filtercustomerIdgte
	 * @param null|int $filtercustomerIdlte
	 * @param null|int $filtercustomerIdcontains
	 * @param null|string $filterbudgetTypeId
	 * @param null|string $filterbudgetTypeIdeq
	 * @param null|string $filterbudgetTypeIdnq
	 * @param null|string $filterbudgetTypeIdgt
	 * @param null|string $filterbudgetTypeIdlt
	 * @param null|string $filterbudgetTypeIdgte
	 * @param null|string $filterbudgetTypeIdlte
	 * @param null|string $filterbudgetTypeIdcontains
	 * @param null|string $filterisArchived
	 * @param null|string $filtercustomerExternalId
	 * @param null|string $filtershowToCustomer
	 * @param null|string $include
	 */
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
	) {
	}


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
