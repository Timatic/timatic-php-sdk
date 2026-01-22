<?php

namespace Timatic\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * entries.destroy
 */
class EntriesDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/entries/{$this->entryId}";
    }

    /**
     * @param  int  $entryId  The entry ID
     */
    public function __construct(
        protected int $entryId,
    ) {}
}
