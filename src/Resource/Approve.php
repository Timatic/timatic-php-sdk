<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Approve\PostOvertimeApprove;

class Approve extends BaseResource
{
	/**
	 * @param string $overtime
	 */
	public function postOvertimeApprove(string $overtime): Response
	{
		return $this->connector->send(new PostOvertimeApprove($overtime));
	}
}
