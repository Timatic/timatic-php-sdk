<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\EntriesExport\GetBudgetEntriesExportRequest;

class EntriesExport extends BaseResource
{
    public function getBudgetEntriesExport(string $budgetId, ?string $include = null): Response
    {
        return $this->connector->send(new GetBudgetEntriesExportRequest($budgetId, $filteruserId, $filteruserIdeq, $filteruserIdnq, $filteruserIdgt, $filteruserIdlt, $filteruserIdgte, $filteruserIdlte, $filteruserIdcontains, $filterbudgetId, $filterbudgetIdeq, $filterbudgetIdnq, $filterbudgetIdgt, $filterbudgetIdlt, $filterbudgetIdgte, $filterbudgetIdlte, $filterbudgetIdcontains, $filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterhasOvertime, $filterhasOvertimeeq, $filterhasOvertimenq, $filterhasOvertimegt, $filterhasOvertimelt, $filterhasOvertimegte, $filterhasOvertimelte, $filterhasOvertimecontains, $filteruserFullName, $filteruserFullNameeq, $filteruserFullNamenq, $filteruserFullNamegt, $filteruserFullNamelt, $filteruserFullNamegte, $filteruserFullNamelte, $filteruserFullNamecontains, $filtercustomerId, $filtercustomerIdeq, $filtercustomerIdnq, $filtercustomerIdgt, $filtercustomerIdlt, $filtercustomerIdgte, $filtercustomerIdlte, $filtercustomerIdcontains, $filterticketNumber, $filterticketNumbereq, $filterticketNumbernq, $filterticketNumbergt, $filterticketNumberlt, $filterticketNumbergte, $filterticketNumberlte, $filterticketNumbercontains, $filtersettlement, $filterisInvoiced, $filterisInvoiceable, $include));
    }
}
