<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Hydration\Model;
use Timatic\SDK\Requests\Entry\DeleteEntryRequest;
use Timatic\SDK\Requests\Entry\GetEntriesRequest;
use Timatic\SDK\Requests\Entry\GetEntryRequest;
use Timatic\SDK\Requests\Entry\PatchEntryRequest;
use Timatic\SDK\Requests\Entry\PostEntriesRequest;

class Entry extends BaseResource
{
    public function getEntries(?string $include = null): Response
    {
        return $this->connector->send(new GetEntriesRequest($filteruserId, $filteruserIdeq, $filteruserIdnq, $filteruserIdgt, $filteruserIdlt, $filteruserIdgte, $filteruserIdlte, $filteruserIdcontains, $filterbudgetId, $filterbudgetIdeq, $filterbudgetIdnq, $filterbudgetIdgt, $filterbudgetIdlt, $filterbudgetIdgte, $filterbudgetIdlte, $filterbudgetIdcontains, $filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterhasOvertime, $filterhasOvertimeeq, $filterhasOvertimenq, $filterhasOvertimegt, $filterhasOvertimelt, $filterhasOvertimegte, $filterhasOvertimelte, $filterhasOvertimecontains, $filteruserFullName, $filteruserFullNameeq, $filteruserFullNamenq, $filteruserFullNamegt, $filteruserFullNamelt, $filteruserFullNamegte, $filteruserFullNamelte, $filteruserFullNamecontains, $filtercustomerId, $filtercustomerIdeq, $filtercustomerIdnq, $filtercustomerIdgt, $filtercustomerIdlt, $filtercustomerIdgte, $filtercustomerIdlte, $filtercustomerIdcontains, $filterticketNumber, $filterticketNumbereq, $filterticketNumbernq, $filterticketNumbergt, $filterticketNumberlt, $filterticketNumbergte, $filterticketNumberlte, $filterticketNumbercontains, $filtersettlement, $filterisInvoiced, $filterisInvoiceable, $include));
    }

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

    public function patchEntry(string $entryId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchEntryRequest($entryId, $data));
    }
}
