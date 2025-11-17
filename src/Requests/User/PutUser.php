<?php

namespace Timatic\SDK\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * putUser
 */
class PutUser extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/users/{$this->user}";
    }

    public function __construct(
        protected string $user,
        protected Model|array $data,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data instanceof Model
            ? $this->data->toJsonApi()
            : ['data' => $this->data];
    }
}
