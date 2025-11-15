<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\MarkAsInvoiced\PostEntryMarkAsInvoiced;

class MarkAsInvoiced extends BaseResource
{
	/**
	 * @param string $entry
	 */
	public function postEntryMarkAsInvoiced(string $entry): Response
	{
		return $this->connector->send(new PostEntryMarkAsInvoiced($entry));
	}
}
