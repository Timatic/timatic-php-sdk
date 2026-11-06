<?php

namespace Timatic\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * users.destroy
 */
class UsersDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

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
