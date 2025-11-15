<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Change\GetChange;
use Timatic\SDK\Requests\Change\GetChanges;

class Change extends BaseResource
{
	/**
	 * @param string $change
	 */
	public function getChange(string $change): Response
	{
		return $this->connector->send(new GetChange($change));
	}


	public function getChanges(): Response
	{
		return $this->connector->send(new GetChanges());
	}
}
