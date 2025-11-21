<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Foundation\Model;
use Timatic\SDK\Requests\MarkAsExported\PostOvertimeMarkAsExportedRequest;

class MarkAsExported extends BaseResource
{
    /**
     * @param  Timatic\SDK\Foundation\Model|array|null  $data  Request data
     */
    public function postOvertimeMarkAsExported(string $overtimeId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostOvertimeMarkAsExportedRequest($overtimeId, $data));
    }
}
