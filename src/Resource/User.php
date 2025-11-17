<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\User\DeleteUser;
use Timatic\SDK\Requests\User\GetUser;
use Timatic\SDK\Requests\User\GetUsers;
use Timatic\SDK\Requests\User\PatchUser;
use Timatic\SDK\Requests\User\PostUsers;

class User extends BaseResource
{
    public function getUsers(?string $filterexternalId = null, ?string $filterexternalIdeq = null): Response
    {
        return $this->connector->send(new GetUsers($filterexternalId, $filterexternalIdeq));
    }

    public function postUsers(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostUsers($data));
    }

    public function getUser(string $user): Response
    {
        return $this->connector->send(new GetUser($user));
    }

    public function deleteUser(string $user): Response
    {
        return $this->connector->send(new DeleteUser($user));
    }

    public function patchUser(string $user, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchUser($user, $data));
    }
}
