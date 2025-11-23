<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Overtime\GetOvertimesRequest;

class Overtime extends BaseResource
{
    public function getOvertimes(): Response
    {
        return $this->connector->send(new GetOvertimesRequest($filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterisApproved, $filterapprovedAt, $filterapprovedAteq, $filterapprovedAtnq, $filterapprovedAtgt, $filterapprovedAtlt, $filterapprovedAtgte, $filterapprovedAtlte, $filterapprovedAtcontains, $filterisExported));
    }
}
