<?php

namespace Timatic\Requests\User;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\User;
use Timatic\Dto\UserRequest;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * users.update
 */
class UsersUpdateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

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
     * @param  null|UserRequest  $data  Request data
     */
    public function __construct(
        protected mixed $userId,
        protected ?UserRequest $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
