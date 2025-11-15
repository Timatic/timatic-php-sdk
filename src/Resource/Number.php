<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Number\GetIncidentsNumber;

class Number extends BaseResource
{
	/**
	 * @param string $incident
	 */
	public function getIncidentsNumber(string $incident): Response
	{
		return $this->connector->send(new GetIncidentsNumber($incident));
	}
}
