<?php

namespace Timatic\SDK\Requests\DailyProgress;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Dto\DailyProgre;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getDailyProgresses
 */
class GetDailyProgressesRequest extends Request implements Paginatable
{
    protected $model = DailyProgre::class;

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
