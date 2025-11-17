<?php

namespace Timatic\SDK\Requests\Incident;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getIncident
 */
class GetIncident extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/incidents/{$this->incident}";
    }

    public function __construct(
        protected string $incident,
    ) {}
}
