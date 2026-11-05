<?php

namespace Timatic\Requests\Correction;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\Correction;
use Timatic\Dto\CorrectionCreateRequest;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * corrections.store
 */
class CorrectionsStoreRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Correction::from(JsonApiTransformer::flatten(
            Correction::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return '/corrections';
    }

    /**
     * @param  null|CorrectionCreateRequest  $data  Request data
     */
    public function __construct(
        protected ?CorrectionCreateRequest $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
