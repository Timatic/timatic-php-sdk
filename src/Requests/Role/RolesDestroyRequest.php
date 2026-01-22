<?php

namespace Timatic\Requests\Role;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * roles.destroy
 */
class RolesDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

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
