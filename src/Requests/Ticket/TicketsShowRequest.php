<?php

namespace Timatic\Requests\Ticket;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\DataTransferObjects\Ticket;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * tickets.show
 */
class TicketsShowRequest extends Request
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Ticket::from(JsonApiTransformer::flatten(
            Ticket::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return "/tickets/{$this->keyId}";
    }

    public function __construct(
        protected string $keyId,
    ) {}
}
