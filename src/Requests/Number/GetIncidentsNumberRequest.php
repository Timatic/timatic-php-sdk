<?php

// auto-generated

namespace Timatic\Requests\Number;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getIncidentsNumber
 */
class GetIncidentsNumberRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/incidents/number/{$this->incidentId}";
    }

    public function __construct(
        protected string $incidentId,
    ) {}
}
