<?php

namespace Timatic\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Team;
use Timatic\Foundation\Hydration\Facades\Hydrator;

/**
 * teams.show
 */
class TeamsShowRequest extends Request
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

    /**
     * @param  int  $teamId  The team ID
     */
    public function __construct(
        protected int $teamId,
    ) {}
}
