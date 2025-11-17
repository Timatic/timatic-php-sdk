<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Incident\GetIncidentRequest;
use Timatic\SDK\Requests\Incident\GetIncidentsRequest;

class Incident extends BaseResource
{
    public function getIncident(string $incident): Response
    {
        return $this->connector->send(new GetIncidentRequest($incident));
    }

    public function getIncidents(): Response
    {
        return $this->connector->send(new GetIncidentsRequest);
    }
}
