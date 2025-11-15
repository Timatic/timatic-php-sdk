<?php

namespace Timatic\SDK\Requests\UserCustomerHoursAggregate;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getUserCustomerHoursAggregates
 */
class GetUserCustomerHoursAggregates extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/user-customer-hours-aggregates";
	}


	/**
	 * @param null|string $filterstartedAt
	 * @param null|string $filterstartedAteq
	 * @param null|string $filterstartedAtnq
	 * @param null|string $filterstartedAtgt
	 * @param null|string $filterstartedAtlt
	 * @param null|string $filterstartedAtgte
	 * @param null|string $filterstartedAtlte
	 * @param null|string $filterstartedAtcontains
	 * @param null|string $filterendedAt
	 * @param null|string $filterendedAteq
	 * @param null|string $filterendedAtnq
	 * @param null|string $filterendedAtgt
	 * @param null|string $filterendedAtlt
	 * @param null|string $filterendedAtgte
	 * @param null|string $filterendedAtlte
	 * @param null|string $filterendedAtcontains
	 * @param null|string $filterteamId
	 * @param null|string $filterteamIdeq
	 * @param null|string $filterteamIdnq
	 * @param null|string $filterteamIdgt
	 * @param null|string $filterteamIdlt
	 * @param null|string $filterteamIdgte
	 * @param null|string $filterteamIdlte
	 * @param null|string $filterteamIdcontains
	 * @param null|string $filteruserId
	 * @param null|string $filteruserIdeq
	 * @param null|string $filteruserIdnq
	 * @param null|string $filteruserIdgt
	 * @param null|string $filteruserIdlt
	 * @param null|string $filteruserIdgte
	 * @param null|string $filteruserIdlte
	 * @param null|string $filteruserIdcontains
	 */
	public function __construct(
		protected ?string $filterstartedAt = null,
		protected ?string $filterstartedAteq = null,
		protected ?string $filterstartedAtnq = null,
		protected ?string $filterstartedAtgt = null,
		protected ?string $filterstartedAtlt = null,
		protected ?string $filterstartedAtgte = null,
		protected ?string $filterstartedAtlte = null,
		protected ?string $filterstartedAtcontains = null,
		protected ?string $filterendedAt = null,
		protected ?string $filterendedAteq = null,
		protected ?string $filterendedAtnq = null,
		protected ?string $filterendedAtgt = null,
		protected ?string $filterendedAtlt = null,
		protected ?string $filterendedAtgte = null,
		protected ?string $filterendedAtlte = null,
		protected ?string $filterendedAtcontains = null,
		protected ?string $filterteamId = null,
		protected ?string $filterteamIdeq = null,
		protected ?string $filterteamIdnq = null,
		protected ?string $filterteamIdgt = null,
		protected ?string $filterteamIdlt = null,
		protected ?string $filterteamIdgte = null,
		protected ?string $filterteamIdlte = null,
		protected ?string $filterteamIdcontains = null,
		protected ?string $filteruserId = null,
		protected ?string $filteruserIdeq = null,
		protected ?string $filteruserIdnq = null,
		protected ?string $filteruserIdgt = null,
		protected ?string $filteruserIdlt = null,
		protected ?string $filteruserIdgte = null,
		protected ?string $filteruserIdlte = null,
		protected ?string $filteruserIdcontains = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'filter[startedAt]' => $this->filterstartedAt,
			'filter[startedAt][eq]' => $this->filterstartedAteq,
			'filter[startedAt][nq]' => $this->filterstartedAtnq,
			'filter[startedAt][gt]' => $this->filterstartedAtgt,
			'filter[startedAt][lt]' => $this->filterstartedAtlt,
			'filter[startedAt][gte]' => $this->filterstartedAtgte,
			'filter[startedAt][lte]' => $this->filterstartedAtlte,
			'filter[startedAt][contains]' => $this->filterstartedAtcontains,
			'filter[endedAt]' => $this->filterendedAt,
			'filter[endedAt][eq]' => $this->filterendedAteq,
			'filter[endedAt][nq]' => $this->filterendedAtnq,
			'filter[endedAt][gt]' => $this->filterendedAtgt,
			'filter[endedAt][lt]' => $this->filterendedAtlt,
			'filter[endedAt][gte]' => $this->filterendedAtgte,
			'filter[endedAt][lte]' => $this->filterendedAtlte,
			'filter[endedAt][contains]' => $this->filterendedAtcontains,
			'filter[teamId]' => $this->filterteamId,
			'filter[teamId][eq]' => $this->filterteamIdeq,
			'filter[teamId][nq]' => $this->filterteamIdnq,
			'filter[teamId][gt]' => $this->filterteamIdgt,
			'filter[teamId][lt]' => $this->filterteamIdlt,
			'filter[teamId][gte]' => $this->filterteamIdgte,
			'filter[teamId][lte]' => $this->filterteamIdlte,
			'filter[teamId][contains]' => $this->filterteamIdcontains,
			'filter[userId]' => $this->filteruserId,
			'filter[userId][eq]' => $this->filteruserIdeq,
			'filter[userId][nq]' => $this->filteruserIdnq,
			'filter[userId][gt]' => $this->filteruserIdgt,
			'filter[userId][lt]' => $this->filteruserIdlt,
			'filter[userId][gte]' => $this->filteruserIdgte,
			'filter[userId][lte]' => $this->filteruserIdlte,
			'filter[userId][contains]' => $this->filteruserIdcontains,
		]);
	}
}
