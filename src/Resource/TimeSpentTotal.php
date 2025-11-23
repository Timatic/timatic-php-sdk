<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\TimeSpentTotal\GetTimeSpentTotalsRequest;

class TimeSpentTotal extends BaseResource
{
    public function getTimeSpentTotals(): Response
    {
        return $this->connector->send(new GetTimeSpentTotalsRequest($filterstartedAtgte, $filterstartedAtlte, $filterteamId, $filterteamIdeq, $filteruserId, $filteruserIdeq));
    }
}
