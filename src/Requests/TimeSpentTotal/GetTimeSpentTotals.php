<?php

namespace Timatic\SDK\Requests\TimeSpentTotal;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getTimeSpentTotals
 */
class GetTimeSpentTotals extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/time-spent-totals";
	}


	/**
	 * @param null|string $filterstartedAtgte
	 * @param null|string $filterstartedAtlte
	 * @param null|string $filterteamId
	 * @param null|string $filterteamIdeq
	 * @param null|string $filteruserId
	 * @param null|string $filteruserIdeq
	 */
	public function __construct(
		protected ?string $filterstartedAtgte = null,
		protected ?string $filterstartedAtlte = null,
		protected ?string $filterteamId = null,
		protected ?string $filterteamIdeq = null,
		protected ?string $filteruserId = null,
		protected ?string $filteruserIdeq = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'filter[startedAt][gte]' => $this->filterstartedAtgte,
			'filter[startedAt][lte]' => $this->filterstartedAtlte,
			'filter[teamId]' => $this->filterteamId,
			'filter[teamId][eq]' => $this->filterteamIdeq,
			'filter[userId]' => $this->filteruserId,
			'filter[userId][eq]' => $this->filteruserIdeq,
		]);
	}
}
