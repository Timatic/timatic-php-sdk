<?php

namespace Timatic\SDK\Requests\UserCustomerHoursAggregate;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getUserCustomerHoursAggregates
 */
class GetUserCustomerHoursAggregatesRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/user-customer-hours-aggregates';
    }

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
    ) {}

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
