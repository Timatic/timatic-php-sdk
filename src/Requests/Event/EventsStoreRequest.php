<?php

namespace Timatic\Requests\Event;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\Event;
use Timatic\Dto\EventRequest;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * events.store
 */
class EventsStoreRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Event::from(JsonApiTransformer::flatten(
            Event::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return '/events';
    }

    /**
     * @param  null|EventRequest  $data  Request data
     */
    public function __construct(
        protected ?EventRequest $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
