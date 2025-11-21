<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Incident\GetIncidentRequest;
use Timatic\SDK\Requests\Incident\GetIncidentsRequest;

class Incident extends BaseResource
{
    public function getIncident(string $incidentId): Response
    {
        return $this->connector->send(new GetIncidentRequest($incidentId));
    }

    public function getIncidents(): Response
    {
        return $this->connector->send(new GetIncidentsRequest);
    }
}
