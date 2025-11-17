<?php

namespace Timatic\SDK\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getTeams
 */
class GetTeams extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/teams';
    }

    public function __construct() {}
}
