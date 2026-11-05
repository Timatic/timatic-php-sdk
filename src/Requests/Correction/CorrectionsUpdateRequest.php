<?php

namespace Timatic\Requests\Correction;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Spatie\LaravelData\Data;
use Timatic\Dto\Correction;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * corrections.update
 */
class CorrectionsUpdateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

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
        return "/corrections/{$this->correctionId}";
    }

    /**
     * @param  mixed  $correctionId  The correction ID
     * @param  null|Data|array|null  $data  Request data
     */
    public function __construct(
        protected mixed $correctionId,
        protected Data|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
