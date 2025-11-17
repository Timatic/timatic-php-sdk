<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
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

    public function postTeams(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostTeamsRequest($data));
    }

    public function getTeam(string $team): Response
    {
        return $this->connector->send(new GetTeamRequest($team));
    }

    public function deleteTeam(string $team): Response
    {
        return $this->connector->send(new DeleteTeamRequest($team));
    }

    public function patchTeam(string $team, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchTeamRequest($team, $data));
    }
}
