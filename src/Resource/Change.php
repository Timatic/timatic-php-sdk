<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Change\GetChangeRequest;
use Timatic\SDK\Requests\Change\GetChangesRequest;

class Change extends BaseResource
{
    public function getChange(string $change): Response
    {
        return $this->connector->send(new GetChangeRequest($change));
    }

    public function getChanges(): Response
    {
        return $this->connector->send(new GetChangesRequest);
    }
}
