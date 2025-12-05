<?php

// auto-generated

namespace Timatic\Requests\DailyProgress;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\DailyProgress;
use Timatic\Hydration\Facades\Hydrator;

/**
 * getDailyProgresses
 */
class GetDailyProgressesRequest extends Request implements Paginatable
{
    protected $model = DailyProgress::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrateCollection(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return '/daily-progress';
    }

    public function __construct() {}
}
