<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Hydration\Model;
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

    public function patchTeam(string $teamId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchTeamRequest($teamId, $data));
    }
}
