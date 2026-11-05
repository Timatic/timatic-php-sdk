<?php

namespace Timatic\Requests\TrackedDomain;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\TrackedDomain;
use Timatic\Dto\TrackedDomainCreateRequest;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * tracked-domains.store
 */
class TrackedDomainsStoreRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function createDtoFromResponse(Response $response): mixed
    {
        return TrackedDomain::from(JsonApiTransformer::flatten(
            TrackedDomain::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return '/tracked-domains';
    }

    /**
     * @param  null|TrackedDomainCreateRequest  $data  Request data
     */
    public function __construct(
        protected ?TrackedDomainCreateRequest $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
