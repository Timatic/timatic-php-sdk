<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Overtime\GetOvertimes;

class Overtime extends BaseResource
{
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
    ): Response {
        return $this->connector->send(new GetOvertimes($filterstartedAt, $filterstartedAteq, $filterstartedAtnq, $filterstartedAtgt, $filterstartedAtlt, $filterstartedAtgte, $filterstartedAtlte, $filterstartedAtcontains, $filterendedAt, $filterendedAteq, $filterendedAtnq, $filterendedAtgt, $filterendedAtlt, $filterendedAtgte, $filterendedAtlte, $filterendedAtcontains, $filterisApproved, $filterapprovedAt, $filterapprovedAteq, $filterapprovedAtnq, $filterapprovedAtgt, $filterapprovedAtlt, $filterapprovedAtgte, $filterapprovedAtlte, $filterapprovedAtcontains, $filterisExported));
    }
}
