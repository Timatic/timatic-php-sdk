<?php

namespace Timatic\SDK\Requests\Number;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\Number;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getIncidentsNumber
 */
class GetIncidentsNumberRequest extends Request
{
    protected $model = Number::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrate(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return "/incidents/number/{$this->incidentId}";
    }

    public function __construct(
        protected string $incidentId,
    ) {}
}
