<?php

namespace Timatic\SDK\Requests\TimeSpentTotal;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getTimeSpentTotals
 */
class GetTimeSpentTotalsRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/time-spent-totals';
    }

    public function __construct(
        protected ?string $filterstartedAtgte = null,
        protected ?string $filterstartedAtlte = null,
        protected ?string $filterteamId = null,
        protected ?string $filterteamIdeq = null,
        protected ?string $filteruserId = null,
        protected ?string $filteruserIdeq = null,
    ) {}

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
