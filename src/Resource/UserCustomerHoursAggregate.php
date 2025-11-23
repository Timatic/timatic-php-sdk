<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\UserCustomerHoursAggregate\GetUserCustomerHoursAggregatesRequest;

class UserCustomerHoursAggregate extends BaseResource
{
    public function getUserCustomerHoursAggregates(): Response
    {
        return $this->connector->send(new GetUserCustomerHoursAggregatesRequest($filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterteamId, $filterteamIdeq, $filterteamIdnq, $filterteamIdgt, $filterteamIdlt, $filterteamIdgte, $filterteamIdlte, $filterteamIdcontains, $filteruserId, $filteruserIdeq, $filteruserIdnq, $filteruserIdgt, $filteruserIdlt, $filteruserIdgte, $filteruserIdlte, $filteruserIdcontains));
    }
}
