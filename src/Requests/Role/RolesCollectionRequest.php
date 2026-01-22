<?php

namespace Timatic\Requests\Role;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\Role;
use Timatic\Foundation\Hydration\Facades\Hydrator;
use Timatic\Foundation\Requests\Concerns\HasIncludes;

/**
 * roles.index
 */
class RolesCollectionRequest extends Request implements Paginatable
{
    use HasIncludes;

    protected $model = Role::class;

    protected Method $method = Method::GET;

    /**
     * Include the permissions relationship in the response
     */
    public function includePermissions(): static
    {
        return $this->addInclude('permissions');
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
        return '/roles';
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
