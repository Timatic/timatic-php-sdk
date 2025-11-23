<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Hydration\Model;
use Timatic\SDK\Requests\MarkAsInvoiced\PostEntryMarkAsInvoicedRequest;

class MarkAsInvoiced extends BaseResource
{
    /**
     * @param  Timatic\SDK\Hydration\Model|array|null  $data  Request data
     */
    public function postEntryMarkAsInvoiced(string $entryId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostEntryMarkAsInvoicedRequest($entryId, $data));
    }
}
