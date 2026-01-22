<?php

namespace Timatic\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\User;
use Timatic\Foundation\Hydration\Facades\Hydrator;
use Timatic\Foundation\Requests\Concerns\HasFilters;
use Timatic\Foundation\Requests\Concerns\HasIncludes;

/**
 * users.index
 */
class UsersCollectionRequest extends Request implements Paginatable
{
    use HasFilters;
    use HasIncludes;

    protected $model = User::class;

    protected Method $method = Method::GET;

    /**
     * Include the roles relationship in the response
     */
    public function includeRoles(): static
    {
        return $this->addInclude('roles');
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

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrateCollection(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
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
