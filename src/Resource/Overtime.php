<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Overtime\GetOvertimes;

class Overtime extends BaseResource
{
	/**
	 * @param string $filterstartedAt
	 * @param string $filterstartedAteq
	 * @param string $filterstartedAtnq
	 * @param string $filterstartedAtgt
	 * @param string $filterstartedAtlt
	 * @param string $filterstartedAtgte
	 * @param string $filterstartedAtlte
	 * @param string $filterstartedAtcontains
	 * @param string $filterendedAt
	 * @param string $filterendedAteq
	 * @param string $filterendedAtnq
	 * @param string $filterendedAtgt
	 * @param string $filterendedAtlt
	 * @param string $filterendedAtgte
	 * @param string $filterendedAtlte
	 * @param string $filterendedAtcontains
	 * @param string $filterisApproved
	 * @param string $filterapprovedAt
	 * @param string $filterapprovedAteq
	 * @param string $filterapprovedAtnq
	 * @param string $filterapprovedAtgt
	 * @param string $filterapprovedAtlt
	 * @param string $filterapprovedAtgte
	 * @param string $filterapprovedAtlte
	 * @param string $filterapprovedAtcontains
	 * @param string $filterisExported
	 */
	public function getOvertimes(
		?string $filterstartedAt = null,
		?string $filterstartedAteq = null,
		?string $filterstartedAtnq = null,
		?string $filterstartedAtgt = null,
		?string $filterstartedAtlt = null,
		?string $filterstartedAtgte = null,
		?string $filterstartedAtlte = null,
		?string $filterstartedAtcontains = null,
		?string $filterendedAt = null,
		?string $filterendedAteq = null,
		?string $filterendedAtnq = null,
		?string $filterendedAtgt = null,
		?string $filterendedAtlt = null,
		?string $filterendedAtgte = null,
		?string $filterendedAtlte = null,
		?string $filterendedAtcontains = null,
		?string $filterisApproved = null,
		?string $filterapprovedAt = null,
		?string $filterapprovedAteq = null,
		?string $filterapprovedAtnq = null,
		?string $filterapprovedAtgt = null,
		?string $filterapprovedAtlt = null,
		?string $filterapprovedAtgte = null,
		?string $filterapprovedAtlte = null,
		?string $filterapprovedAtcontains = null,
		?string $filterisExported = null,
	): Response
	{
		return $this->connector->send(new GetOvertimes($filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterisApproved, $filterapprovedAt, $filterapprovedAteq, $filterapprovedAtnq, $filterapprovedAtgt, $filterapprovedAtlt, $filterapprovedAtgte, $filterapprovedAtlte, $filterapprovedAtcontains, $filterisExported));
	}
}
