<?php

namespace Timatic\Requests\SuggestionIntegration;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\SuggestionIntegration;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * suggestion-integrations.index
 */
class SuggestionIntegrationsCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            SuggestionIntegration::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => SuggestionIntegration::from($flat));
    }

    public function resolveEndpoint(): string
    {
        return '/suggestion-integrations';
    }

    public function __construct() {}
}
