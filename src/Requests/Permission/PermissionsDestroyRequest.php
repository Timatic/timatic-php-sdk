<?php

// auto-generated

namespace Timatic\Requests\Permission;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * permissions.destroy
 */
class PermissionsDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

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
