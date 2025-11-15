<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\UserCustomerHoursAggregate\GetUserCustomerHoursAggregates;

class UserCustomerHoursAggregate extends BaseResource
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
	 * @param string $filterteamId
	 * @param string $filterteamIdeq
	 * @param string $filterteamIdnq
	 * @param string $filterteamIdgt
	 * @param string $filterteamIdlt
	 * @param string $filterteamIdgte
	 * @param string $filterteamIdlte
	 * @param string $filterteamIdcontains
	 * @param string $filteruserId
	 * @param string $filteruserIdeq
	 * @param string $filteruserIdnq
	 * @param string $filteruserIdgt
	 * @param string $filteruserIdlt
	 * @param string $filteruserIdgte
	 * @param string $filteruserIdlte
	 * @param string $filteruserIdcontains
	 */
	public function getUserCustomerHoursAggregates(
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
		?string $filterteamId = null,
		?string $filterteamIdeq = null,
		?string $filterteamIdnq = null,
		?string $filterteamIdgt = null,
		?string $filterteamIdlt = null,
		?string $filterteamIdgte = null,
		?string $filterteamIdlte = null,
		?string $filterteamIdcontains = null,
		?string $filteruserId = null,
		?string $filteruserIdeq = null,
		?string $filteruserIdnq = null,
		?string $filteruserIdgt = null,
		?string $filteruserIdlt = null,
		?string $filteruserIdgte = null,
		?string $filteruserIdlte = null,
		?string $filteruserIdcontains = null,
	): Response
	{
		return $this->connector->send(new GetUserCustomerHoursAggregates($filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterteamId, $filterteamIdeq, $filterteamIdnq, $filterteamIdgt, $filterteamIdlt, $filterteamIdgte, $filterteamIdlte, $filterteamIdcontains, $filteruserId, $filteruserIdeq, $filteruserIdnq, $filteruserIdgt, $filteruserIdlt, $filteruserIdgte, $filteruserIdlte, $filteruserIdcontains));
	}
}
