<?php

namespace Timatic\SDK\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\Team;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getTeam
 */
class GetTeamRequest extends Request
{
    protected $model = Team::class;

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
        return "/teams/{$this->teamId}";
    }

    public function __construct(
        protected string $teamId,
    ) {}
}
