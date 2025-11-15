<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Correction\PatchCorrection;
use Timatic\SDK\Requests\Correction\PostCorrections;
use Timatic\SDK\Requests\Correction\PutCorrection;

class Correction extends BaseResource
{
	public function postCorrections(): Response
	{
		return $this->connector->send(new PostCorrections());
	}


	/**
	 * @param string $correction
	 */
	public function putCorrection(string $correction): Response
	{
		return $this->connector->send(new PutCorrection($correction));
	}


	/**
	 * @param string $correction
	 */
	public function patchCorrection(string $correction): Response
	{
		return $this->connector->send(new PatchCorrection($correction));
	}
}
