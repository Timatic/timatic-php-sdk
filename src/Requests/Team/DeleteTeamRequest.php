<?php

// auto-generated

namespace Timatic\Requests\Team;

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
        return "/teams/{$this->teamId}";
    }

    public function __construct(
        protected string $teamId,
    ) {}
}
