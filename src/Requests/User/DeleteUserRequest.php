<?php

// auto-generated

namespace Timatic\Requests\User;

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
        return "/users/{$this->userId}";
    }

    public function __construct(
        protected string $userId,
    ) {}
}
