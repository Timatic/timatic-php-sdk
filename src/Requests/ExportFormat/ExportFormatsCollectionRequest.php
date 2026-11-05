<?php

namespace Timatic\Requests\ExportFormat;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\ExportFormat;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * export-formats.index
 */
class ExportFormatsCollectionRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            ExportFormat::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => ExportFormat::from($flat));
    }

    public function resolveEndpoint(): string
    {
        return '/export-formats';
    }

    public function __construct() {}
}
