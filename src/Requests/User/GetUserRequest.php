<?php

namespace Timatic\SDK\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\User;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getUser
 */
class GetUserRequest extends Request
{
    protected $model = User::class;

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
        return "/users/{$this->userId}";
    }

    public function __construct(
        protected string $userId,
    ) {}
}
