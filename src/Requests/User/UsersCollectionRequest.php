<?php

namespace Timatic\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\DataTransferObjects\User;
use Timatic\Foundation\JsonApi\JsonApiTransformer;
use Timatic\Foundation\Requests\Concerns\HasFilters;
use Timatic\Foundation\Requests\Concerns\HasIncludes;

/**
 * users.index
 */
class UsersCollectionRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        $flattened = JsonApiTransformer::flattenCollection(
            User::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        );

        return collect($flattened)->map(fn (array $flat) => User::from($flat));
    }

    /**
     * Include the permissions relationship in the response
     */
    public function includePermissions(): static
    {
        return $this->addInclude('permissions');
    }

    /**
     * Include the team relationship in the response
     */
    public function includeTeam(): static
    {
        return $this->addInclude('team');
    }

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    /**
     * @param  null|int  $pagesize  The number of results that will be returned per page.
     * @param  null|int  $pagenumber  The page number to start the pagination from.
     */
    public function __construct(
        protected ?int $pagesize = null,
        protected ?int $pagenumber = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page[size]' => $this->pagesize, 'page[number]' => $this->pagenumber]);
    }
}
