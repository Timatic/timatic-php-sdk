<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\User\DeleteUserRequest;
use Timatic\SDK\Requests\User\GetUserRequest;
use Timatic\SDK\Requests\User\GetUsersRequest;
use Timatic\SDK\Requests\User\PatchUserRequest;
use Timatic\SDK\Requests\User\PostUsersRequest;

class User extends BaseResource
{
    public function getUsers(?string $filterexternalId = null, ?string $filterexternalIdeq = null): Response
    {
        return $this->connector->send(new GetUsersRequest($filterexternalId, $filterexternalIdeq));
    }

    public function postUsers(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostUsersRequest($data));
    }

    public function getUser(string $user): Response
    {
        return $this->connector->send(new GetUserRequest($user));
    }

    public function deleteUser(string $user): Response
    {
        return $this->connector->send(new DeleteUserRequest($user));
    }

    public function patchUser(string $user, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchUserRequest($user, $data));
    }
}
