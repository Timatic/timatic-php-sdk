<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\MarkAsExported\PostOvertimeMarkAsExported;

class MarkAsExported extends BaseResource
{
	/**
	 * @param string $overtime
	 */
	public function postOvertimeMarkAsExported(string $overtime): Response
	{
		return $this->connector->send(new PostOvertimeMarkAsExported($overtime));
	}
}
