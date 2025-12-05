<?php

// auto-generated

namespace Timatic\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Entry;
use Timatic\Hydration\Facades\Hydrator;

/**
 * getEntry
 */
class GetEntryRequest extends Request
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

    public function __construct(
        protected string $entryId,
    ) {}
}
