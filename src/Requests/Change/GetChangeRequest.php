<?php

namespace Timatic\SDK\Requests\Change;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\Change;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getChange
 */
class GetChangeRequest extends Request
{
    protected $model = Change::class;

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
        return "/changes/{$this->changeId}";
    }

    public function __construct(
        protected string $changeId,
    ) {}
}
