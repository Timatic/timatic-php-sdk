<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Hydration\Model;
use Timatic\SDK\Requests\Event\PostEventsRequest;

class Event extends BaseResource
{
    public function postEvents(Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostEventsRequest($data));
    }
}
