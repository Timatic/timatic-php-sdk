<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Requests\Approve\PostOvertimeApproveRequest;

class Approve extends BaseResource
{
    /**
     * @param  Timatic\SDK\Concerns\Model|array|null  $data  Request data
     */
    public function postOvertimeApprove(string $overtimeId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostOvertimeApproveRequest($overtimeId, $data));
    }
}
