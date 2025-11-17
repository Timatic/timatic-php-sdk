<?php

namespace Timatic\SDK\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteTeam
 */
class DeleteTeamRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->team}";
    }

    public function __construct(
        protected string $team,
    ) {}
}
