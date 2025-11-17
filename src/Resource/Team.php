<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Team\DeleteTeam;
use Timatic\SDK\Requests\Team\GetTeam;
use Timatic\SDK\Requests\Team\GetTeams;
use Timatic\SDK\Requests\Team\PatchTeam;
use Timatic\SDK\Requests\Team\PostTeams;
use Timatic\SDK\Requests\Team\PutTeam;

class Team extends BaseResource
{
    public function getTeams(): Response
    {
        return $this->connector->send(new GetTeams);
    }

    public function postTeams(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostTeams($data));
    }

    public function getTeam(string $team): Response
    {
        return $this->connector->send(new GetTeam($team));
    }

    public function putTeam(string $team, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PutTeam($team, $data));
    }

    public function deleteTeam(string $team): Response
    {
        return $this->connector->send(new DeleteTeam($team));
    }

    public function patchTeam(string $team, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchTeam($team, $data));
    }
}
