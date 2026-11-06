<?php

namespace Timatic\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\DataTransferObjects\User;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * users.show
 */
class UsersShowRequest extends Request
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return User::from(JsonApiTransformer::flatten(
            User::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return "/users/{$this->userId}";
    }

    /**
     * @param  mixed  $userId  The user ID
     */
    public function __construct(
        protected mixed $userId,
    ) {}
}
