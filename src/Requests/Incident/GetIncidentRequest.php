<?php

namespace Timatic\SDK\Requests\Incident;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\Incident;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getIncident
 */
class GetIncidentRequest extends Request
{
    protected $model = Incident::class;

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
        return "/incidents/{$this->incidentId}";
    }

    public function __construct(
        protected string $incidentId,
    ) {}
}
