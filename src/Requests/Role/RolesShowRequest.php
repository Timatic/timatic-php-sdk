<?php

// auto-generated

namespace Timatic\Requests\Role;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\Dto\Role;
use Timatic\Hydration\Facades\Hydrator;

/**
 * roles.show
 */
class RolesShowRequest extends Request
{
    protected $model = Role::class;

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
        return "/roles/{$this->roleId}";
    }

    /**
     * @param  int  $roleId  The role ID
     */
    public function __construct(
        protected int $roleId,
    ) {}
}
