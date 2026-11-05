<?php

namespace Timatic\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Team;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * teams.show
 */
class TeamsShowRequest extends Request
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Team::from(JsonApiTransformer::flatten(
            Team::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}";
    }

    /**
     * @param  mixed  $teamId  The team ID
     */
    public function __construct(
        protected mixed $teamId,
    ) {}
}
