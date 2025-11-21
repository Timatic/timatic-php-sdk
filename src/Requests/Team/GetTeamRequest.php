<?php

namespace Timatic\SDK\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getTeam
 */
class GetTeamRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}";
    }

    public function __construct(
        protected string $teamId,
    ) {}
}
