<?php

// auto-generated

namespace Timatic\Requests\Change;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getChanges
 */
class GetChangesRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/changes';
    }

    public function __construct() {}
}
