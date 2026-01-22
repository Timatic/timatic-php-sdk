<?php

namespace Timatic\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\User;
use Timatic\Foundation\Hydration\Facades\Hydrator;

/**
 * users.show
 */
class UsersShowRequest extends Request
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

    /**
     * @param  int  $userId  The user ID
     */
    public function __construct(
        protected int $userId,
    ) {}
}
