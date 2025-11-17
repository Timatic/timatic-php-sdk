<?php

namespace Timatic\SDK\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * putTeam
 */
class PutTeam extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->team}";
    }

    public function __construct(
        protected string $team,
        protected Model|array $data,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data instanceof Model
            ? $this->data->toJsonApi()
            : ['data' => $this->data];
    }
}
