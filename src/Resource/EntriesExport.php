<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\EntriesExport\GetBudgetEntriesExport;

class EntriesExport extends BaseResource
{
	/**
	 * @param string $budget
	 * @param string $filteruserId
	 * @param string $filteruserIdeq
	 * @param string $filteruserIdnq
	 * @param string $filteruserIdgt
	 * @param string $filteruserIdlt
	 * @param string $filteruserIdgte
	 * @param string $filteruserIdlte
	 * @param string $filteruserIdcontains
	 * @param string $filterbudgetId
	 * @param string $filterbudgetIdeq
	 * @param string $filterbudgetIdnq
	 * @param string $filterbudgetIdgt
	 * @param string $filterbudgetIdlt
	 * @param string $filterbudgetIdgte
	 * @param string $filterbudgetIdlte
	 * @param string $filterbudgetIdcontains
	 * @param string $filterstartedAt
	 * @param string $filterstartedAteq
	 * @param string $filterstartedAtnq
	 * @param string $filterstartedAtgt
	 * @param string $filterstartedAtlt
	 * @param string $filterstartedAtgte
	 * @param string $filterstartedAtlte
	 * @param string $filterstartedAtcontains
	 * @param string $filterendedAt
	 * @param string $filterendedAteq
	 * @param string $filterendedAtnq
	 * @param string $filterendedAtgt
	 * @param string $filterendedAtlt
	 * @param string $filterendedAtgte
	 * @param string $filterendedAtlte
	 * @param string $filterendedAtcontains
	 * @param string $filterhasOvertime
	 * @param string $filterhasOvertimeeq
	 * @param string $filterhasOvertimenq
	 * @param string $filterhasOvertimegt
	 * @param string $filterhasOvertimelt
	 * @param string $filterhasOvertimegte
	 * @param string $filterhasOvertimelte
	 * @param string $filterhasOvertimecontains
	 * @param string $filteruserFullName
	 * @param string $filteruserFullNameeq
	 * @param string $filteruserFullNamenq
	 * @param string $filteruserFullNamegt
	 * @param string $filteruserFullNamelt
	 * @param string $filteruserFullNamegte
	 * @param string $filteruserFullNamelte
	 * @param string $filteruserFullNamecontains
	 * @param string $filtercustomerId
	 * @param string $filtercustomerIdeq
	 * @param string $filtercustomerIdnq
	 * @param string $filtercustomerIdgt
	 * @param string $filtercustomerIdlt
	 * @param string $filtercustomerIdgte
	 * @param string $filtercustomerIdlte
	 * @param string $filtercustomerIdcontains
	 * @param string $filterticketNumber
	 * @param string $filterticketNumbereq
	 * @param string $filterticketNumbernq
	 * @param string $filterticketNumbergt
	 * @param string $filterticketNumberlt
	 * @param string $filterticketNumbergte
	 * @param string $filterticketNumberlte
	 * @param string $filterticketNumbercontains
	 * @param string $filtersettlement
	 * @param string $filterisInvoiced
	 * @param string $filterisInvoiceable
	 * @param string $include
	 */
	public function getBudgetEntriesExport(
		string $budget,
		?string $filteruserId = null,
		?string $filteruserIdeq = null,
		?string $filteruserIdnq = null,
		?string $filteruserIdgt = null,
		?string $filteruserIdlt = null,
		?string $filteruserIdgte = null,
		?string $filteruserIdlte = null,
		?string $filteruserIdcontains = null,
		?string $filterbudgetId = null,
		?string $filterbudgetIdeq = null,
		?string $filterbudgetIdnq = null,
		?string $filterbudgetIdgt = null,
		?string $filterbudgetIdlt = null,
		?string $filterbudgetIdgte = null,
		?string $filterbudgetIdlte = null,
		?string $filterbudgetIdcontains = null,
		?string $filterstartedAt = null,
		?string $filterstartedAteq = null,
		?string $filterstartedAtnq = null,
		?string $filterstartedAtgt = null,
		?string $filterstartedAtlt = null,
		?string $filterstartedAtgte = null,
		?string $filterstartedAtlte = null,
		?string $filterstartedAtcontains = null,
		?string $filterendedAt = null,
		?string $filterendedAteq = null,
		?string $filterendedAtnq = null,
		?string $filterendedAtgt = null,
		?string $filterendedAtlt = null,
		?string $filterendedAtgte = null,
		?string $filterendedAtlte = null,
		?string $filterendedAtcontains = null,
		?string $filterhasOvertime = null,
		?string $filterhasOvertimeeq = null,
		?string $filterhasOvertimenq = null,
		?string $filterhasOvertimegt = null,
		?string $filterhasOvertimelt = null,
		?string $filterhasOvertimegte = null,
		?string $filterhasOvertimelte = null,
		?string $filterhasOvertimecontains = null,
		?string $filteruserFullName = null,
		?string $filteruserFullNameeq = null,
		?string $filteruserFullNamenq = null,
		?string $filteruserFullNamegt = null,
		?string $filteruserFullNamelt = null,
		?string $filteruserFullNamegte = null,
		?string $filteruserFullNamelte = null,
		?string $filteruserFullNamecontains = null,
		?string $filtercustomerId = null,
		?string $filtercustomerIdeq = null,
		?string $filtercustomerIdnq = null,
		?string $filtercustomerIdgt = null,
		?string $filtercustomerIdlt = null,
		?string $filtercustomerIdgte = null,
		?string $filtercustomerIdlte = null,
		?string $filtercustomerIdcontains = null,
		?string $filterticketNumber = null,
		?string $filterticketNumbereq = null,
		?string $filterticketNumbernq = null,
		?string $filterticketNumbergt = null,
		?string $filterticketNumberlt = null,
		?string $filterticketNumbergte = null,
		?string $filterticketNumberlte = null,
		?string $filterticketNumbercontains = null,
		?string $filtersettlement = null,
		?string $filterisInvoiced = null,
		?string $filterisInvoiceable = null,
		?string $include = null,
	): Response
	{
		return $this->connector->send(new GetBudgetEntriesExport($budget, $filteruserId, $filteruserIdeq, $filteruserIdnq, $filteruserIdgt, $filteruserIdlt, $filteruserIdgte, $filteruserIdlte, $filteruserIdcontains, $filterbudgetId, $filterbudgetIdeq, $filterbudgetIdnq, $filterbudgetIdgt, $filterbudgetIdlt, $filterbudgetIdgte, $filterbudgetIdlte, $filterbudgetIdcontains, $filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterhasOvertime, $filterhasOvertimeeq, $filterhasOvertimenq, $filterhasOvertimegt, $filterhasOvertimelt, $filterhasOvertimegte, $filterhasOvertimelte, $filterhasOvertimecontains, $filteruserFullName, $filteruserFullNameeq, $filteruserFullNamenq, $filteruserFullNamegt, $filteruserFullNamelt, $filteruserFullNamegte, $filteruserFullNamelte, $filteruserFullNamecontains, $filtercustomerId, $filtercustomerIdeq, $filtercustomerIdnq, $filtercustomerIdgt, $filtercustomerIdlt, $filtercustomerIdgte, $filtercustomerIdlte, $filtercustomerIdcontains, $filterticketNumber, $filterticketNumbereq, $filterticketNumbernq, $filterticketNumbergt, $filterticketNumberlt, $filterticketNumbergte, $filterticketNumberlte, $filterticketNumbercontains, $filtersettlement, $filterisInvoiced, $filterisInvoiceable, $include));
	}
}
