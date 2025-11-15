<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Incident\GetIncident;
use Timatic\SDK\Requests\Incident\GetIncidents;

class Incident extends BaseResource
{
	/**
	 * @param string $incident
	 */
	public function getIncident(string $incident): Response
	{
		return $this->connector->send(new GetIncident($incident));
	}


	public function getIncidents(): Response
	{
		return $this->connector->send(new GetIncidents());
	}
}
