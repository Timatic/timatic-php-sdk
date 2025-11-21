<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Number\GetIncidentsNumberRequest;

class Number extends BaseResource
{
    public function getIncidentsNumber(string $incidentId): Response
    {
        return $this->connector->send(new GetIncidentsNumberRequest($incidentId));
    }
}
