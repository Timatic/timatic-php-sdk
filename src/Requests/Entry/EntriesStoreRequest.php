<?php

namespace Timatic\Requests\Entry;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\Entry;
use Timatic\Dto\EntryCreateRequest;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * entries.store
 */
class EntriesStoreRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

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
        return '/entries';
    }

    /**
     * @param  null|EntryCreateRequest  $data  Request data
     */
    public function __construct(
        protected ?EntryCreateRequest $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
