<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\MarkAsExported\PostOvertimeMarkAsExportedRequest;

class MarkAsExported extends BaseResource
{
    public function postOvertimeMarkAsExported(
        string $overtime,
        \Timatic\SDK\Foundation\Model|array|null $data = null,
    ): Response {
        return $this->connector->send(new PostOvertimeMarkAsExportedRequest($overtime, $data));
    }
}
