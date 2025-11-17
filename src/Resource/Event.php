<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Event\PostEvents;

class Event extends BaseResource
{
    public function postEvents(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostEvents($data));
    }
}
