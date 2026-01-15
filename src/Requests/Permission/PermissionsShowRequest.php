<?php

// auto-generated

namespace Timatic\Requests\Permission;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Permission;
use Timatic\Hydration\Facades\Hydrator;

/**
 * permissions.show
 */
class PermissionsShowRequest extends Request
{
    protected $model = Permission::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrate(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return "/permissions/{$this->permissionId}";
    }

    /**
     * @param  int  $permissionId  The permission ID
     */
    public function __construct(
        protected int $permissionId,
    ) {}
}
