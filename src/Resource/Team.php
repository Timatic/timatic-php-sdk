<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Requests\Team\DeleteTeamRequest;
use Timatic\SDK\Requests\Team\GetTeamRequest;
use Timatic\SDK\Requests\Team\GetTeamsRequest;
use Timatic\SDK\Requests\Team\PatchTeamRequest;
use Timatic\SDK\Requests\Team\PostTeamsRequest;

class Team extends BaseResource
{
    public function getTeams(): Response
    {
        return $this->connector->send(new GetTeamsRequest);
    }

    /**
     * @param  Timatic\SDK\Concerns\Model|array|null  $data  Request data
     */
    public function postTeams(Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostTeamsRequest($data));
    }

    public function getTeam(string $teamId): Response
    {
        return $this->connector->send(new GetTeamRequest($teamId));
    }

    public function deleteTeam(string $teamId): Response
    {
        return $this->connector->send(new DeleteTeamRequest($teamId));
    }

    /**
     * @param  Timatic\SDK\Concerns\Model|array|null  $data  Request data
     */
    public function patchTeam(string $teamId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchTeamRequest($teamId, $data));
    }
}
