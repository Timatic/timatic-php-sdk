<?php

namespace Timatic\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Entry;
use Timatic\Foundation\Hydration\Facades\Hydrator;

/**
 * entries.show
 */
class EntriesShowRequest extends Request
{
    protected $model = Entry::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrate(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

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
