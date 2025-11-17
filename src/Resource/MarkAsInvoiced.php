<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\MarkAsInvoiced\PostEntryMarkAsInvoicedRequest;

class MarkAsInvoiced extends BaseResource
{
    public function postEntryMarkAsInvoiced(
        string $entry,
        \Timatic\SDK\Foundation\Model|array|null $data = null,
    ): Response {
        return $this->connector->send(new PostEntryMarkAsInvoicedRequest($entry, $data));
    }
}
