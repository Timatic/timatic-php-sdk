<?php

namespace Timatic\SDK\Requests\EntriesExport;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBudgetEntriesExport
 */
class GetBudgetEntriesExport extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/budgets/{$this->budget}/entries-export";
	}


	/**
	 * @param string $budget
	 * @param null|string $filteruserId
	 * @param null|string $filteruserIdeq
	 * @param null|string $filteruserIdnq
	 * @param null|string $filteruserIdgt
	 * @param null|string $filteruserIdlt
	 * @param null|string $filteruserIdgte
	 * @param null|string $filteruserIdlte
	 * @param null|string $filteruserIdcontains
	 * @param null|string $filterbudgetId
	 * @param null|string $filterbudgetIdeq
	 * @param null|string $filterbudgetIdnq
	 * @param null|string $filterbudgetIdgt
	 * @param null|string $filterbudgetIdlt
	 * @param null|string $filterbudgetIdgte
	 * @param null|string $filterbudgetIdlte
	 * @param null|string $filterbudgetIdcontains
	 * @param null|string $filterstartedAt
	 * @param null|string $filterstartedAteq
	 * @param null|string $filterstartedAtnq
	 * @param null|string $filterstartedAtgt
	 * @param null|string $filterstartedAtlt
	 * @param null|string $filterstartedAtgte
	 * @param null|string $filterstartedAtlte
	 * @param null|string $filterstartedAtcontains
	 * @param null|string $filterendedAt
	 * @param null|string $filterendedAteq
	 * @param null|string $filterendedAtnq
	 * @param null|string $filterendedAtgt
	 * @param null|string $filterendedAtlt
	 * @param null|string $filterendedAtgte
	 * @param null|string $filterendedAtlte
	 * @param null|string $filterendedAtcontains
	 * @param null|string $filterhasOvertime
	 * @param null|string $filterhasOvertimeeq
	 * @param null|string $filterhasOvertimenq
	 * @param null|string $filterhasOvertimegt
	 * @param null|string $filterhasOvertimelt
	 * @param null|string $filterhasOvertimegte
	 * @param null|string $filterhasOvertimelte
	 * @param null|string $filterhasOvertimecontains
	 * @param null|string $filteruserFullName
	 * @param null|string $filteruserFullNameeq
	 * @param null|string $filteruserFullNamenq
	 * @param null|string $filteruserFullNamegt
	 * @param null|string $filteruserFullNamelt
	 * @param null|string $filteruserFullNamegte
	 * @param null|string $filteruserFullNamelte
	 * @param null|string $filteruserFullNamecontains
	 * @param null|string $filtercustomerId
	 * @param null|string $filtercustomerIdeq
	 * @param null|string $filtercustomerIdnq
	 * @param null|string $filtercustomerIdgt
	 * @param null|string $filtercustomerIdlt
	 * @param null|string $filtercustomerIdgte
	 * @param null|string $filtercustomerIdlte
	 * @param null|string $filtercustomerIdcontains
	 * @param null|string $filterticketNumber
	 * @param null|string $filterticketNumbereq
	 * @param null|string $filterticketNumbernq
	 * @param null|string $filterticketNumbergt
	 * @param null|string $filterticketNumberlt
	 * @param null|string $filterticketNumbergte
	 * @param null|string $filterticketNumberlte
	 * @param null|string $filterticketNumbercontains
	 * @param null|string $filtersettlement
	 * @param null|string $filterisInvoiced
	 * @param null|string $filterisInvoiceable
	 * @param null|string $include
	 */
	public function __construct(
		protected string $budget,
		protected ?string $filteruserId = null,
		protected ?string $filteruserIdeq = null,
		protected ?string $filteruserIdnq = null,
		protected ?string $filteruserIdgt = null,
		protected ?string $filteruserIdlt = null,
		protected ?string $filteruserIdgte = null,
		protected ?string $filteruserIdlte = null,
		protected ?string $filteruserIdcontains = null,
		protected ?string $filterbudgetId = null,
		protected ?string $filterbudgetIdeq = null,
		protected ?string $filterbudgetIdnq = null,
		protected ?string $filterbudgetIdgt = null,
		protected ?string $filterbudgetIdlt = null,
		protected ?string $filterbudgetIdgte = null,
		protected ?string $filterbudgetIdlte = null,
		protected ?string $filterbudgetIdcontains = null,
		protected ?string $filterstartedAt = null,
		protected ?string $filterstartedAteq = null,
		protected ?string $filterstartedAtnq = null,
		protected ?string $filterstartedAtgt = null,
		protected ?string $filterstartedAtlt = null,
		protected ?string $filterstartedAtgte = null,
		protected ?string $filterstartedAtlte = null,
		protected ?string $filterstartedAtcontains = null,
		protected ?string $filterendedAt = null,
		protected ?string $filterendedAteq = null,
		protected ?string $filterendedAtnq = null,
		protected ?string $filterendedAtgt = null,
		protected ?string $filterendedAtlt = null,
		protected ?string $filterendedAtgte = null,
		protected ?string $filterendedAtlte = null,
		protected ?string $filterendedAtcontains = null,
		protected ?string $filterhasOvertime = null,
		protected ?string $filterhasOvertimeeq = null,
		protected ?string $filterhasOvertimenq = null,
		protected ?string $filterhasOvertimegt = null,
		protected ?string $filterhasOvertimelt = null,
		protected ?string $filterhasOvertimegte = null,
		protected ?string $filterhasOvertimelte = null,
		protected ?string $filterhasOvertimecontains = null,
		protected ?string $filteruserFullName = null,
		protected ?string $filteruserFullNameeq = null,
		protected ?string $filteruserFullNamenq = null,
		protected ?string $filteruserFullNamegt = null,
		protected ?string $filteruserFullNamelt = null,
		protected ?string $filteruserFullNamegte = null,
		protected ?string $filteruserFullNamelte = null,
		protected ?string $filteruserFullNamecontains = null,
		protected ?string $filtercustomerId = null,
		protected ?string $filtercustomerIdeq = null,
		protected ?string $filtercustomerIdnq = null,
		protected ?string $filtercustomerIdgt = null,
		protected ?string $filtercustomerIdlt = null,
		protected ?string $filtercustomerIdgte = null,
		protected ?string $filtercustomerIdlte = null,
		protected ?string $filtercustomerIdcontains = null,
		protected ?string $filterticketNumber = null,
		protected ?string $filterticketNumbereq = null,
		protected ?string $filterticketNumbernq = null,
		protected ?string $filterticketNumbergt = null,
		protected ?string $filterticketNumberlt = null,
		protected ?string $filterticketNumbergte = null,
		protected ?string $filterticketNumberlte = null,
		protected ?string $filterticketNumbercontains = null,
		protected ?string $filtersettlement = null,
		protected ?string $filterisInvoiced = null,
		protected ?string $filterisInvoiceable = null,
		protected ?string $include = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'filter[userId]' => $this->filteruserId,
			'filter[userId][eq]' => $this->filteruserIdeq,
			'filter[userId][nq]' => $this->filteruserIdnq,
			'filter[userId][gt]' => $this->filteruserIdgt,
			'filter[userId][lt]' => $this->filteruserIdlt,
			'filter[userId][gte]' => $this->filteruserIdgte,
			'filter[userId][lte]' => $this->filteruserIdlte,
			'filter[userId][contains]' => $this->filteruserIdcontains,
			'filter[budgetId]' => $this->filterbudgetId,
			'filter[budgetId][eq]' => $this->filterbudgetIdeq,
			'filter[budgetId][nq]' => $this->filterbudgetIdnq,
			'filter[budgetId][gt]' => $this->filterbudgetIdgt,
			'filter[budgetId][lt]' => $this->filterbudgetIdlt,
			'filter[budgetId][gte]' => $this->filterbudgetIdgte,
			'filter[budgetId][lte]' => $this->filterbudgetIdlte,
			'filter[budgetId][contains]' => $this->filterbudgetIdcontains,
			'filter[startedAt]' => $this->filterstartedAt,
			'filter[startedAt][eq]' => $this->filterstartedAteq,
			'filter[startedAt][nq]' => $this->filterstartedAtnq,
			'filter[startedAt][gt]' => $this->filterstartedAtgt,
			'filter[startedAt][lt]' => $this->filterstartedAtlt,
			'filter[startedAt][gte]' => $this->filterstartedAtgte,
			'filter[startedAt][lte]' => $this->filterstartedAtlte,
			'filter[startedAt][contains]' => $this->filterstartedAtcontains,
			'filter[endedAt]' => $this->filterendedAt,
			'filter[endedAt][eq]' => $this->filterendedAteq,
			'filter[endedAt][nq]' => $this->filterendedAtnq,
			'filter[endedAt][gt]' => $this->filterendedAtgt,
			'filter[endedAt][lt]' => $this->filterendedAtlt,
			'filter[endedAt][gte]' => $this->filterendedAtgte,
			'filter[endedAt][lte]' => $this->filterendedAtlte,
			'filter[endedAt][contains]' => $this->filterendedAtcontains,
			'filter[hasOvertime]' => $this->filterhasOvertime,
			'filter[hasOvertime][eq]' => $this->filterhasOvertimeeq,
			'filter[hasOvertime][nq]' => $this->filterhasOvertimenq,
			'filter[hasOvertime][gt]' => $this->filterhasOvertimegt,
			'filter[hasOvertime][lt]' => $this->filterhasOvertimelt,
			'filter[hasOvertime][gte]' => $this->filterhasOvertimegte,
			'filter[hasOvertime][lte]' => $this->filterhasOvertimelte,
			'filter[hasOvertime][contains]' => $this->filterhasOvertimecontains,
			'filter[userFullName]' => $this->filteruserFullName,
			'filter[userFullName][eq]' => $this->filteruserFullNameeq,
			'filter[userFullName][nq]' => $this->filteruserFullNamenq,
			'filter[userFullName][gt]' => $this->filteruserFullNamegt,
			'filter[userFullName][lt]' => $this->filteruserFullNamelt,
			'filter[userFullName][gte]' => $this->filteruserFullNamegte,
			'filter[userFullName][lte]' => $this->filteruserFullNamelte,
			'filter[userFullName][contains]' => $this->filteruserFullNamecontains,
			'filter[customerId]' => $this->filtercustomerId,
			'filter[customerId][eq]' => $this->filtercustomerIdeq,
			'filter[customerId][nq]' => $this->filtercustomerIdnq,
			'filter[customerId][gt]' => $this->filtercustomerIdgt,
			'filter[customerId][lt]' => $this->filtercustomerIdlt,
			'filter[customerId][gte]' => $this->filtercustomerIdgte,
			'filter[customerId][lte]' => $this->filtercustomerIdlte,
			'filter[customerId][contains]' => $this->filtercustomerIdcontains,
			'filter[ticketNumber]' => $this->filterticketNumber,
			'filter[ticketNumber][eq]' => $this->filterticketNumbereq,
			'filter[ticketNumber][nq]' => $this->filterticketNumbernq,
			'filter[ticketNumber][gt]' => $this->filterticketNumbergt,
			'filter[ticketNumber][lt]' => $this->filterticketNumberlt,
			'filter[ticketNumber][gte]' => $this->filterticketNumbergte,
			'filter[ticketNumber][lte]' => $this->filterticketNumberlte,
			'filter[ticketNumber][contains]' => $this->filterticketNumbercontains,
			'filter[settlement]' => $this->filtersettlement,
			'filter[isInvoiced]' => $this->filterisInvoiced,
			'filter[isInvoiceable]' => $this->filterisInvoiceable,
			'include' => $this->include,
		]);
	}
}
