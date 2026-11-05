<?php

namespace Timatic\Requests\Team;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Spatie\LaravelData\Data;
use Timatic\Dto\Team;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * teams.update
 */
class TeamsUpdateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

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
     * @param  null|Data|array|null  $data  Request data
     */
    public function __construct(
        protected mixed $teamId,
        protected Data|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
