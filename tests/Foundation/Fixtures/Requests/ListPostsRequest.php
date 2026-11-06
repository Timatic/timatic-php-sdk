<?php

declare(strict_types=1);

namespace Timatic\Tests\Foundation\Fixtures\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Foundation\JsonApi\JsonApiTransformer;
use Timatic\Foundation\Requests\Concerns\HasFilters;
use Timatic\Foundation\Requests\Concerns\HasIncludes;
use Timatic\Tests\Foundation\Fixtures\DataTransferObjects\Post;

class ListPostsRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            Post::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => Post::from($flat));
    }

    public function resolveEndpoint(): string
    {
        return '/posts';
    }

    public function includeAuthor(): static
    {
        return $this->addInclude('author');
    }

    public function includeComments(): static
    {
        return $this->addInclude('comments');
    }
}
