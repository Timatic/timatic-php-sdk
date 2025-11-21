<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Requests\Entry\DeleteEntryRequest;
use Timatic\SDK\Requests\Entry\GetEntriesRequest;
use Timatic\SDK\Requests\Entry\GetEntryRequest;
use Timatic\SDK\Requests\Entry\PatchEntryRequest;
use Timatic\SDK\Requests\Entry\PostEntriesRequest;

class Entry extends BaseResource
{
    public function getEntries(
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
    ): Response {
        return $this->connector->send(new GetEntriesRequest($filteruserId, $filteruserIdeq, $filteruserIdnq, $filteruserIdgt, $filteruserIdlt, $filteruserIdgte, $filteruserIdlte, $filteruserIdcontains, $filterbudgetId, $filterbudgetIdeq, $filterbudgetIdnq, $filterbudgetIdgt, $filterbudgetIdlt, $filterbudgetIdgte, $filterbudgetIdlte, $filterbudgetIdcontains, $filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterhasOvertime, $filterhasOvertimeeq, $filterhasOvertimenq, $filterhasOvertimegt, $filterhasOvertimelt, $filterhasOvertimegte, $filterhasOvertimelte, $filterhasOvertimecontains, $filteruserFullName, $filteruserFullNameeq, $filteruserFullNamenq, $filteruserFullNamegt, $filteruserFullNamelt, $filteruserFullNamegte, $filteruserFullNamelte, $filteruserFullNamecontains, $filtercustomerId, $filtercustomerIdeq, $filtercustomerIdnq, $filtercustomerIdgt, $filtercustomerIdlt, $filtercustomerIdgte, $filtercustomerIdlte, $filtercustomerIdcontains, $filterticketNumber, $filterticketNumbereq, $filterticketNumbernq, $filterticketNumbergt, $filterticketNumberlt, $filterticketNumbergte, $filterticketNumberlte, $filterticketNumbercontains, $filtersettlement, $filterisInvoiced, $filterisInvoiceable, $include));
    }

    /**
     * @param  Timatic\SDK\Concerns\Model|array|null  $data  Request data
     */
    public function postEntries(Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostEntriesRequest($data));
    }

    public function getEntry(string $entryId): Response
    {
        return $this->connector->send(new GetEntryRequest($entryId));
    }

    public function deleteEntry(string $entryId): Response
    {
        return $this->connector->send(new DeleteEntryRequest($entryId));
    }

    /**
     * @param  Timatic\SDK\Concerns\Model|array|null  $data  Request data
     */
    public function patchEntry(string $entryId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchEntryRequest($entryId, $data));
    }
}
