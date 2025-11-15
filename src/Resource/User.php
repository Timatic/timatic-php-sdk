<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\User\DeleteUser;
use Timatic\SDK\Requests\User\GetUser;
use Timatic\SDK\Requests\User\GetUsers;
use Timatic\SDK\Requests\User\PatchUser;
use Timatic\SDK\Requests\User\PostUsers;
use Timatic\SDK\Requests\User\PutUser;

class User extends BaseResource
{
	/**
	 * @param string $filterexternalId
	 * @param string $filterexternalIdeq
	 */
	public function getUsers(?string $filterexternalId = null, ?string $filterexternalIdeq = null): Response
	{
		return $this->connector->send(new GetUsers($filterexternalId, $filterexternalIdeq));
	}


	public function postUsers(): Response
	{
		return $this->connector->send(new PostUsers());
	}


	/**
	 * @param string $user
	 */
	public function getUser(string $user): Response
	{
		return $this->connector->send(new GetUser($user));
	}


	/**
	 * @param string $user
	 */
	public function putUser(string $user): Response
	{
		return $this->connector->send(new PutUser($user));
	}


	/**
	 * @param string $user
	 */
	public function deleteUser(string $user): Response
	{
		return $this->connector->send(new DeleteUser($user));
	}


	/**
	 * @param string $user
	 */
	public function patchUser(string $user): Response
	{
		return $this->connector->send(new PatchUser($user));
	}
}
