<?php

namespace Timatic\SDK\Requests\Incident;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getIncidents
 */
class GetIncidentsRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/incidents';
    }

    public function __construct() {}
}
