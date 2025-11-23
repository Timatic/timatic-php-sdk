<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Hydration\Model;
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

    /**
     * @param  Timatic\SDK\Hydration\Model|array|null  $data  Request data
     */
    public function postUsers(Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostUsersRequest($data));
    }

    public function getUser(string $userId): Response
    {
        return $this->connector->send(new GetUserRequest($userId));
    }

    public function deleteUser(string $userId): Response
    {
        return $this->connector->send(new DeleteUserRequest($userId));
    }

    /**
     * @param  Timatic\SDK\Hydration\Model|array|null  $data  Request data
     */
    public function patchUser(string $userId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchUserRequest($userId, $data));
    }
}
