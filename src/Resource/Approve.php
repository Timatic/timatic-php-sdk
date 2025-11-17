<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Approve\PostOvertimeApprove;

class Approve extends BaseResource
{
    public function postOvertimeApprove(
        string $overtime,
        \Timatic\SDK\Foundation\Model|array|null $data = null,
    ): Response {
        return $this->connector->send(new PostOvertimeApprove($overtime, $data));
    }
}
