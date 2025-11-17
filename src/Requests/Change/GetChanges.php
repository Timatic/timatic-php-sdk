<?php

namespace Timatic\SDK\Requests\Change;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getChanges
 */
class GetChanges extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/changes';
    }

    public function __construct() {}
}
