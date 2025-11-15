<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\EntrySuggestion\DeleteEntrySuggestion;
use Timatic\SDK\Requests\EntrySuggestion\GetEntrySuggestion;
use Timatic\SDK\Requests\EntrySuggestion\GetEntrySuggestions;

class EntrySuggestion extends BaseResource
{
	/**
	 * @param string $filterdate
	 * @param string $filterdateeq
	 * @param string $filterdatenq
	 * @param string $filterdategt
	 * @param string $filterdatelt
	 * @param string $filterdategte
	 * @param string $filterdatelte
	 * @param string $filterdatecontains
	 */
	public function getEntrySuggestions(
		?string $filterdate = null,
		?string $filterdateeq = null,
		?string $filterdatenq = null,
		?string $filterdategt = null,
		?string $filterdatelt = null,
		?string $filterdategte = null,
		?string $filterdatelte = null,
		?string $filterdatecontains = null,
	): Response
	{
		return $this->connector->send(new GetEntrySuggestions($filterdate, $filterdateeq, $filterdatenq, $filterdategt, $filterdatelt, $filterdategte, $filterdatelte, $filterdatecontains));
	}


	/**
	 * @param string $entrySuggestion
	 */
	public function getEntrySuggestion(string $entrySuggestion): Response
	{
		return $this->connector->send(new GetEntrySuggestion($entrySuggestion));
	}


	/**
	 * @param string $entrySuggestion
	 */
	public function deleteEntrySuggestion(string $entrySuggestion): Response
	{
		return $this->connector->send(new DeleteEntrySuggestion($entrySuggestion));
	}
}
