<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\TimeSpentTotal\GetTimeSpentTotalsRequest;

class TimeSpentTotal extends BaseResource
{
    public function getTimeSpentTotals(
        ?string $filterstartedAtgte = null,
        ?string $filterstartedAtlte = null,
        ?string $filterteamId = null,
        ?string $filterteamIdeq = null,
        ?string $filteruserId = null,
        ?string $filteruserIdeq = null,
    ): Response {
        return $this->connector->send(new GetTimeSpentTotalsRequest($filterstartedAtgte, $filterstartedAtlte, $filterteamId, $filterteamIdeq, $filteruserId, $filteruserIdeq));
    }
}
