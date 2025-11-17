<?php

namespace Timatic\SDK\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteUser
 */
class DeleteUserRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/users/{$this->user}";
    }

    public function __construct(
        protected string $user,
    ) {}
}
