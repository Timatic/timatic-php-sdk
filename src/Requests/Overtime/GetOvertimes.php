<?php

namespace Timatic\SDK\Requests\Overtime;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getOvertimes
 */
class GetOvertimes extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/overtimes';
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
