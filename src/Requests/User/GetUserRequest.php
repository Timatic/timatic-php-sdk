<?php

namespace Timatic\SDK\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getUser
 */
class GetUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/users/{$this->user}";
    }

    public function __construct(
        protected string $user,
    ) {}
}
