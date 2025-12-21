<?php

// auto-generated

namespace Timatic\Requests\Team;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * teams.destroy
 */
class TeamsDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/teams/{$this->teamId}";
    }

    /**
     * @param  int  $teamId  The team ID
     */
    public function __construct(
        protected int $teamId,
    ) {}
}
