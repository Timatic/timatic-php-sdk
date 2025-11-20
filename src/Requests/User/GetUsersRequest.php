<?php

namespace Timatic\SDK\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;

/**
 * getUsers
 */
class GetUsersRequest extends Request implements Paginatable
{
    use HasFilters;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    public function __construct() {}
}
