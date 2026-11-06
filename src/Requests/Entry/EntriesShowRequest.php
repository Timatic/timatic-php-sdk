<?php

namespace Timatic\Requests\Entry;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\DataTransferObjects\Entry;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * entries.show
 */
class EntriesShowRequest extends Request
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Entry::from(JsonApiTransformer::flatten(
            Entry::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
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
