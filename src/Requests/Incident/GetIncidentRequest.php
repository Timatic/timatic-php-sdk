<?php

namespace Timatic\SDK\Requests\Incident;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getIncident
 */
class GetIncidentRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/incidents/{$this->incidentId}";
    }

    public function __construct(
        protected string $incidentId,
    ) {}
}
