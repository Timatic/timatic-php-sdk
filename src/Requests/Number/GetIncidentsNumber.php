<?php

namespace Timatic\SDK\Requests\Number;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getIncidentsNumber
 */
class GetIncidentsNumber extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/incidents/number/{$this->incident}";
    }

    public function __construct(
        protected string $incident,
    ) {}
}
