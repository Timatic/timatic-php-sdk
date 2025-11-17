<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Me\GetMesRequest;

class Me extends BaseResource
{
    public function getMes(): Response
    {
        return $this->connector->send(new GetMesRequest);
    }
}
