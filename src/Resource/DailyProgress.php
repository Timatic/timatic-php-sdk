<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\DailyProgress\GetDailyProgressesRequest;

class DailyProgress extends BaseResource
{
    public function getDailyProgresses(): Response
    {
        return $this->connector->send(new GetDailyProgressesRequest);
    }
}
