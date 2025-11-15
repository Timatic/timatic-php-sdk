<?php

namespace Timatic\SDK\Requests\Overtime;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getOvertimes
 */
class GetOvertimes extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/overtimes";
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
	 * @param null|string $filterisApproved
	 * @param null|string $filterapprovedAt
	 * @param null|string $filterapprovedAteq
	 * @param null|string $filterapprovedAtnq
	 * @param null|string $filterapprovedAtgt
	 * @param null|string $filterapprovedAtlt
	 * @param null|string $filterapprovedAtgte
	 * @param null|string $filterapprovedAtlte
	 * @param null|string $filterapprovedAtcontains
	 * @param null|string $filterisExported
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
		protected ?string $filterisApproved = null,
		protected ?string $filterapprovedAt = null,
		protected ?string $filterapprovedAteq = null,
		protected ?string $filterapprovedAtnq = null,
		protected ?string $filterapprovedAtgt = null,
		protected ?string $filterapprovedAtlt = null,
		protected ?string $filterapprovedAtgte = null,
		protected ?string $filterapprovedAtlte = null,
		protected ?string $filterapprovedAtcontains = null,
		protected ?string $filterisExported = null,
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
			'filter[isApproved]' => $this->filterisApproved,
			'filter[approvedAt]' => $this->filterapprovedAt,
			'filter[approvedAt][eq]' => $this->filterapprovedAteq,
			'filter[approvedAt][nq]' => $this->filterapprovedAtnq,
			'filter[approvedAt][gt]' => $this->filterapprovedAtgt,
			'filter[approvedAt][lt]' => $this->filterapprovedAtlt,
			'filter[approvedAt][gte]' => $this->filterapprovedAtgte,
			'filter[approvedAt][lte]' => $this->filterapprovedAtlte,
			'filter[approvedAt][contains]' => $this->filterapprovedAtcontains,
			'filter[isExported]' => $this->filterisExported,
		]);
	}
}
