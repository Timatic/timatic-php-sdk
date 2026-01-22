<?php

namespace Timatic\Requests\Role;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\Role;
use Timatic\Foundation\Hydration\Facades\Hydrator;
use Timatic\Foundation\Hydration\Model;

/**
 * roles.update
 */
class RolesUpdateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = Role::class;

    protected Method $method = Method::PATCH;

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
     * @param  null|\Timatic\Foundation\Hydration\Model|array|null  $data  Request data
     */
    public function __construct(
        protected int $roleId,
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => $this->data->toJsonApi()] : [];
    }
}
