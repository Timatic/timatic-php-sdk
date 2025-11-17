<?php

namespace Timatic\SDK\Requests\DailyProgress;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getDailyProgresses
 */
class GetDailyProgresses extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/daily-progress';
    }

    public function __construct() {}
}
